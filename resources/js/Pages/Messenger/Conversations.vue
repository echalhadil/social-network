<template>
    <div class="px-2 overflow-auto h-full conv">
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

        <inertia-link
            v-if="!loading"
            v-for="conversation in conversations"
            :key="conversation.id"
            :href="'/conversations/' + conversation.id"
            class="mt-2 cursor-pointer group shadow px-1 py-2 w-full flex rounded"
            :class="{
                'bg-white hover:bg-gray-50': conversation.id != $page.id,
                'bg-indigo-500 hover:bg-indigo-600': conversation.id == $page.id
            }"
        >
            <div class=" p-1 ">
                <img
                    :src="'/' + conversation.friend.picture"
                    class=" h-14 w-14 object-cover rounded-full"
                />
            </div>
            <div
                class="my-auto w-3/4"
                :class="{ 'text-white': conversation.id == $page.id }"
            >
                <p class=" capitalize font-semibold ">
                    {{ conversation.friend.firstname }}
                    {{ conversation.friend.lastname }}
                </p>
                <div class="flex ">
                    <p class="text-sm truncate">
                        {{ conversation.friend.last_message }} .
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
            </div>
            <div class=" ml-auto mr-2">
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
            </div>
        </inertia-link>
    </div>
</template>

<style>
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
export default {
    data() {
        return {
            conversations: [],
            loading: true
        };
    },
    methods: {
        getConversations() {
            axios
                .get(route("conversations.index"))
                .then(res => {
                    this.conversations = _.orderBy(
                        res.data,
                        ["updated_at"],
                        ["desc"]
                    );
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },

    mounted() {
        this.getConversations();
    }
};
</script>
