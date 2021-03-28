<template>
    <div
        :class="{
            'invisible sm:visible': !route().current('messenger'),
            'w-full': route().current('messenger')
        }"
        class=" mx-auto w-0 sm:visible  sm:w-1/4 regular-conversations-height  "
    >
        <div class="w-full flex p-2">
            <p class="capitalize text-lg font-semibold">conversation</p>

            <i
                @click="getFriends"
                class="fal fa-plus my-auto ml-auto mr-4 text-indigo-500 cursor-pointer"
                aria-hidden="true"
            ></i>

            <jet-dialog-modal
                :show="startConversation"
                @close="startConversation = false"
            >
                <template #title>
                    start conversation
                </template>

                <template #content>
                    <div class="mt-4 max-h overflow-y-auto">
                        <!-- waiting-->

                        <div v-if="waitingForFriends" class="flex">
                            <div class=" p-1 ">
                                <div
                                    class=" h-14 w-14  rounded-full bg-gray-300 loading "
                                ></div>
                            </div>
                            <div class="my-auto w-3/4">
                                <div
                                    class=" capitalize font-semibold h-3 w-20 rounded-full bg-gray-300  loading"
                                ></div>
                                <div
                                    class=" capitalize font-semibold h-2 w-12 mt-2 rounded-full bg-gray-300 loading "
                                ></div>
                            </div>
                        </div>
                        <!-- waiting -->

                        <div
                            v-for="friend in friends"
                            :key="friend.id"
                            @click="selectedFriend = friend"
                            :class="{'bg-gray-100':selectedFriend!=null &&  selectedFriend.id == friend.id}"
                            class="flex cursor-pointer hover:bg-gray-50"
                            >
                            <div class=" p-1 ">
                                <img
                                    :src="'/' + friend.picture"
                                    class=" h-14 w-14 object-cover rounded-full"
                                />
                            </div>
                            <div class="my-auto w-3/4">
                                <p class=" capitalize font-semibold ">
                                    {{ friend.firstname }}
                                    {{ friend.lastname }}
                                </p>
                                <div class=" capitalize text-gray-600 ">
                                    Online
                                </div>
                            </div>
                        </div>

                    </div>
                </template>

                <template #footer>
                    <jet-secondary-button
                        @click.native="startConversation = false"
                        
                    >
                        <span v-on:click="selectedFriend = null" >Cancel</span>
                    </jet-secondary-button>

                    <button
                        class="ml-2 px-4 py-2 ring shadow border rounded-md bg-indigo-500 text-white  hover:text-indigo-500 hover:bg-gray-50"
                        :disabled="selectedFriend == null "
                        :class="{ 'opacity-50':selectedFriend== null }"
                        @click=" startMessage=true"
                    >
                        next
                    </button>
                </template>
            
            </jet-dialog-modal>




            <jet-dialog-modal
                :show="startMessage"
                @close="startMessage = false"
            >
                <template #title>
                    type something
                </template>

                <template #content>
                    <div class="mt-4 max-h overflow-y-auto">
                        


                        <div >

                            <textarea v-model="newMessage" class="resize-none border rounded-md w-full"></textarea>
                        </div>

                    </div>
                </template>

                <template #footer>
                    <jet-secondary-button
                        @click.native="startMessage = false"
                        
                    >
                        <span v-on:click="selectedFriend = null" >Cancel</span>
                    </jet-secondary-button>

                    <button
                        class="ml-2 px-4 py-2 ring shadow border rounded-md bg-indigo-500 text-white  hover:text-indigo-500 hover:bg-gray-50"
                        :disabled="newMessage == '' "
                        :class="{ 'opacity-50':newMessage== '' }"
                        @click="sendMessage"
                    >
                        send
                    </button>


                            <!-- message -->
                            <div
                                v-if="message.visible"
                                class="relative py-3 pl-4 pr-10 leading-normal rounded-lg  "
                                :class="{
                                    'text-green-700 bg-green-100': message.type,
                                    'text-red-700 bg-red-100': !message.type
                                }"
                                role="alert"
                            >
                                <p class=" capitalize ">{{ message.content }}</p>
                                <span class="absolute inset-y-0 right-0 flex items-center mr-4">
                                    <svg
                                        @click="message.visible = false"
                                        class="w-4 h-4 fill-current"
                                        role="button"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                            fill-rule="evenodd"
                                        ></path>
                                    </svg>
                                </span>
                            </div>
                            <!--message -->
                </template>
            </jet-dialog-modal>










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
                        loading="lazy"
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


<script>
import JetActionSection from "@/Jetstream/ActionSection";
import JetDialogModal from "@/Jetstream/DialogModal";
import JetDangerButton from "@/Jetstream/DangerButton";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";
import JetDropdown from "@/Jetstream/Dropdown";
import Swal from "sweetalert";

export default {
    components: {
        JetActionSection,
        JetDangerButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        JetDropdown
    },
    data() {
        return {
            conversations: [],
            friends: [],
            mainConversations: [],
            loading: true,
            searchValue: "",
            startConversation: false,
            startMessage:false,
            waitingForFriends: true,
            selectedFriend: null,
            newMessage:'',
            message: {
                type: true,
                content: "",
                visible: false
            }
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
                text:
                    "Once deleted, you will not be able to recover this conversation",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then(willDelete => {
                if (willDelete) {
                    swal("Your conversation has been deleted!", {
                        icon: "success",
                        button: "close"
                    });

                    this.conversations = _.filter(this.conversations, c => {
                        return c.id != id;
                    });
                    this.mainConversations = _.filter(
                        this.mainConversations,
                        c => {
                            return c.id != id;
                        }
                    );

                    axios
                        .delete("/conversations/" + id)
                        .then(response => {
                            console.log(response.data);
                            window.location = "/messenger";
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
            });
        },
        getFriends() {
            this.startConversation = true;
            axios
                .get(route("friends.index"))
                .then(res => {
                    this.friends = _.orderBy(res.data, ["id"], ["desc"]);
                    console.table(this.friends);
                    this.waitingForFriends = false;
                })
                .catch(err => {
                    console.log(err);
                });
        },
        sendMessage(){

            if(this.selectedFriend!=null && this.newMessage!='')
            {
                

                let c = {'to_id':this.selectedFriend.id,'text':this.newMessage};
                axios.post('/conversations',c)
                .then(
                    res =>{                     
                        this.selectedFriend = null ;
                        this.newMessage = '';
                        this.startConversation =false;                  
                        var index = _.findIndex(this.conversations, {'id': res.data.id});
                        if(index>=0)
                            this.conversations.splice(index, 1, res.data);
                        else
                        {
                            this.conversations.unshift(res.data);
                            // this.mainConversations.unshift(res.data);
                        }
                        this.message = {
                            type: true,
                            content: "message sent.",
                            visible: true
                        };
                        setTimeout(() => {
                            this.message = {
                                type: true,
                                content: "",
                                visible: false
                            };
                            this.startMessage= false;
                        }, 2000);
                    }
                )
                .catch(
                    err => {
                        console.log(err);
                        this.message = {
                            type: false,
                            content: "something is wrong .",
                            visible: true
                        };
                    }
                )
            }
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
.conv {
    height: calc(100vh - 12rem);
}

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
.max-h {
    max-height: 18rem;
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

