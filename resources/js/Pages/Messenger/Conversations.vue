<template>
    <div
        :class="{
            'invisible sm:visible': !route().current('messenger'),
            'w-full': route().current('messenger')
        }"
        class=" mx-auto w-0 sm:visible  sm:w-1/4 regular-conversations-height  "
    >
        <div class="w-full p-2">
            <p class="capitalize text-lg font-semibold">conversation</p>
        </div>

        <div class="px-2 py-1">
            <input
                v-model="searchValue"
                type="text"
                placeholder="Search Here"
                class="focus:outline-none focus:ring-2 focus:border-indigo-500 ml-auto bg-transparent h-10 capitalize w-full border-gray-300 border rounded-md "
            />
        </div>

        <div class="px-2 overflow-auto  conv">
            <!-- waiting to get data -->
            <div v-if="loading">
                <div
                    v-for="item in [1, 2]"
                    class="mt-2 px-1 py-2 w-full bg-white flex rounded"
                >
                    <div class=" p-1 ">
                        <div class=" h-14 w-14 rounded-full loading "></div>
                    </div>
                    <div class="my-auto w-4/5">
                        <div
                            class=" capitalize font-semibold rounded-full  w-28  h-5 loading "
                        ></div>
                        <div class="flex mt-1 ">
                            <div
                                class=" w-3/4 my-auto h-3 loading rounded-full"
                            ></div>
                            <span
                                class="ml-1 my-auto h-3 w-1/6 rounded-full loading text-xs"
                            ></span>
                        </div>
                    </div>
                    <div class=" ml-auto mr-2">
                        <div
                            class="rounded-full w-4 h-2 bg-gray-100"
                            aria-hidden="true"
                        ></div>
                    </div>
                </div>
            </div>

            <div
                v-if="!loading"
                v-for="conversation in mainConversations"
                :key="conversation.id"
                class="mt-2 cursor-pointer group shadow p-2 w-full flex rounded"
                :class="{
                    'bg-white hover:bg-gray-50': conversation.id != $page.id,
                    'bg-indigo-500 hover:bg-indigo-600':
                        conversation.id == $page.id
                }"
            >
                <inertia-link
                    class=" p-1 "
                    :href="'/conversations/' + conversation.id"
                >
                    <img
                        :src="'/' + conversation.friend.picture"
                        class=" h-14 w-14 object-cover rounded-full"
                    />
                </inertia-link>
                <inertia-link
                    :href="'/conversations/' + conversation.id"
                    class="my-auto w-3/4"
                    :class="{ 'text-white': conversation.id == $page.id }"
                >
                    <p class=" capitalize font-semibold ">
                        {{ conversation.friend.firstname }}
                        {{ conversation.friend.lastname }}
                    </p>
                    <div class="flex ">
                        <p class="text-sm truncate">
                            {{ conversation.last_message }} .
                        </p>
                        <span
                            class="pl-1 my-auto  text-xs"
                            :class="{
                                'text-white': conversation.id == $page.id,
                                'text-blue-700': conversation.id != $page.id
                            }"
                            >{{ conversation.timeago }}</span
                        >
                    </div>
                </inertia-link>
                <div class=" ml-auto mr-2">
                    <jet-dropdown align="right" width="auto" class="ml-auto">
                        <template class="" #trigger>
                            <i
                                class="fa fa-ellipsis-h"
                                :class="{
                                    'hover:text-gray-700 text-gray-600':
                                        conversation.id != $page.id,
                                    'hover:text-gray-50 text-white':
                                        conversation.id == $page.id
                                }"
                                aria-hidden="true"
                            ></i>
                        </template>

                        <template #content>
                            <div
                                @click="deleteConversation(conversation.id)"
                                class="p-2 flex hover:text-indigo-500 cursor-pointer"
                            >
                                <i
                                    class="fal my-auto fa-trash-alt pr-1"
                                    aria-hidden="true"
                                ></i>
                                delete
                            </div>
                        </template>
                    </jet-dropdown>

                    <div
                        v-if="true && conversation.id != $page.id"
                        class="ml-auto my-auto"
                    >
                        <i
                            class="fa fa-circle text-indigo-500 fa-xs circle   "
                        ></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.regular-conversations-height {
    height: calc(100vh - 6rem);
}
.conv::-webkit-scrollbar {
    width: 5px;
}

.conv::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.conv::-webkit-scrollbar-thumb {
    background: #e5e7eb;
}

.conv::-webkit-scrollbar-thumb:hover {
    background: #e5e8ef;
}

.loading {
    background: linear-gradient(to right, #e5e7eb, #e3e3e3);
    animation: mymove 1s infinite;
}
@keyframes mymove {
    0% {
        background: linear-gradient(to right, #e5e7eb, #e3e3e3);
    }

    50% {
        background: linear-gradient(to right, #e3e3e3, #e3e3e3);
    }

    100% {
        background: linear-gradient(to left, #e5e7eb, #e3e3e3);
    }
}
</style>

<script>
import JetDropdown from "@/Jetstream/Dropdown";
import Swal from "sweetalert";

export default {
    components: {
        JetDropdown
    },
    data() {
        return {
            conversations: [],
            mainConversations: [],
            loading: true,
            searchValue: ""
        };
    },
    watch: {
        searchValue: _.debounce(function() {
            this.search();
        }, 150)
    },
    methods: {
        getConversations() {
            axios
                .get(route("conversations.index"))
                .then(res => {
                    this.mainConversations = this.conversations = _.orderBy(
                        res.data,
                        ["updated_at"],
                        ["desc"]
                    );
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err);
                });
        },

        search() {
            let v = this.searchValue.toLowerCase();
            this.mainConversations = _.filter(this.conversations, function(o) {
                return (
                    _.includes(o.friend.firstname.toLowerCase(), v) ||
                    _.includes(o.friend.lastname.toLowerCase(), v) ||
                    _.includes(
                        o.friend.lastname.toLowerCase() +
                            " " +
                            o.friend.firstname.toLowerCase(),
                        v
                    ) ||
                    _.includes(
                        o.friend.firstname.toLowerCase() +
                            " " +
                            o.friend.lastname.toLowerCase(),
                        v
                    )
                );
            });
            console.table(this.mainConversations);
        },
        deleteConversation(id) {
           

              swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this conversation",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then(willDelete => {
                if (willDelete) {
                    swal("Your conversation has been deleted!", {
                        icon: "success",
                        button: "close"
                    });

                    this.conversations = _.filter(this.conversations, c =>{ return c.id != id; });
                    this.mainConversations = _.filter(this.mainConversations,  c =>{ return c.id != id; });




                    
                }
            });
        }
    },

    mounted() {
        this.getConversations();

        Echo.channel("message-channel-" + this.$page.user.id).listen(
            ".MessageEvent",
            data => {
                let conversation = data.conversation;

                var c = _.find(this.conversations, ["id", conversation.id]);
                c = conversation;

                var match = _.find(this.conversations, ["id", conversation.id]);
                if (match) {
                    var index = _.indexOf(
                        this.conversations,
                        _.find(this.conversations, ["id", conversation.id])
                    );
                    this.conversations.splice(index, 1, conversation);
                    this.conversations = _.orderBy(
                        this.conversations,
                        ["updated_at"],
                        ["desc"]
                    );
                } else {
                    this.conversations.unshift(conversation);
                }

                //    else
                //    this.conversations.unshift(conversation);
            }
        );
    }
};
</script>

<style>
.circle {
    font-size: xx-small;
}
.conv{
        height: calc(100vh - 12rem);
}
</style>
