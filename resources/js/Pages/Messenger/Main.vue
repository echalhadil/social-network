<template>
    <app-layout>
        <div class="flex mt-6 mx-3 ">
            <conversations />
            <div
                class=" regular-messages-height w-0  sm:w-2/4 sm:visible  "
                :class="{
                    invisible: route().current('messenger'),
                    'w-full': !route().current('messenger')
                }"
            >
                <div
                    v-if="route().current('messenger')"
                    class=" relative text-center top-1/2 -translate-y-3/5 text-gray-500 my-auto "
                >
                    <i class="fab fa-pushed fa-6x" aria-hidden="true"></i>
                    <p class="mt-1 text-xl font-semibold capitalize">
                        start conversation
                    </p>
                </div>
                <friend v-if="!route().current('messenger')" />

                <div
                    v-if="!route().current('messenger')"
                    class=" w-full h-full messages overflow-auto mt-3 "
                >
                    <!-- loading for message -->
                    <div v-if="loading">
                        <div class="p-2 flex">
                            <div class="h-10 w-10 rounded-full loading"></div>
                            <div class="ml-2 w-3/4">
                                <div
                                    class=" shadow p-2 loading rounded-t-lg rounded-r-lg h-20 w-full "
                                >
                                    <div class="text-gray-700 text-sm"></div>
                                </div>
                                <div class="capitalize mt-1">
                                    <div
                                        class="w-9 h-3 rounded-full loading "
                                    ></div>
                                </div>
                            </div>
                            <div
                                class="my-auto mx-auto loading w-4 h-2 rounded-full "
                            ></div>
                        </div>

                        <div class="p-2 flex">
                            <div
                                class="my-auto ml-auto loading w-4 h-2 rounded-full "
                            ></div>

                            <div class="ml-auto w-3/4 ">
                                <div
                                    class="ml-auto p-2 shadow loading h-20 rounded-t-lg rounded-l-lg w-full "
                                >
                                    <div class="text-white text-sm"></div>
                                </div>
                                <div class="w-3/4 ml-auto capitalize mt-1">
                                    <div
                                        class="float-right w-9 h-3 rounded-full loading "
                                    ></div>
                                </div>
                            </div>

                            <div
                                class="h-10 w-10 rounded-full ml-2 loading"
                            ></div>
                        </div>
                    </div>
                    <message
                        v-if="!route().current('messenger')"
                        v-for="message in messages"
                        :key="message.id"
                        :message="message"
                    />
                    
                    <div
                        v-if="!loading && messages.length == 0"
                        class=" relative text-center mt-8 -translate-y-3/5 text-gray-500 my-auto "
                    >
                        <i class="fab fa-pushed fa-6x" aria-hidden="true"></i>
                        <p class="mt-1 text-xl font-semibold capitalize">
                            start conversation
                        </p>
                    </div>

                    <div class="bottom mb-16"></div>
                </div>

                <send-message
                    v-if="!route().current('messenger')"
                    @send-message="sendMessage"
                />
            </div>

            <div class="mx-2 w-0 invisible sm:w-1/4 sm:visible">
                <div class="p-2 bg-white w-full rounded-lg">
                    <div class=" ">
                        <img
                            :src="
                                route().current('messenger')
                                    ? '/' + $page.user.picture
                                    : '/' + $page.friend.picture
                            "
                            class="mx-auto h-28 w-28 object-cover rounded-full "
                        />
                    </div>
                    <div class=" text-center mt-1">
                        <p class=" text-xl font-bold ">
                            {{
                                route().current("messenger")
                                    ? $page.user.firstname
                                    : $page.friend.firstname
                            }}
                            {{
                                route().current("messenger")
                                    ? $page.user.lastname
                                    : $page.friend.lastname
                            }}
                        </p>
                        <p class=" text-md  ">
                            @{{
                                route().current("messenger")
                                    ? $page.user.username
                                    : $page.friend.username
                            }}
                        </p>
                    </div>

                    <inertia-link
                        :href="
                            route().current('messenger')
                                ? '/profiles/' + $page.user.id
                                : '/profiles/' + $page.friend.id
                        "
                        class="flex mx-auto w-11/12  text-center mt-3 p-2 hover:bg-gray-50 hover:text-indigo-500"
                    >
                        <i
                            class=" ml-auto fal fa-user my-auto"
                            aria-hidden="true"
                        ></i>
                        <p class="my-auto mr-auto ml-1 capitalize  ">
                            view profile
                        </p>
                    </inertia-link>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Conversations from "./Conversations";
import SendMessage from "./SendMessage";
import Message from "./Message";
import Friend from "./Friend";

export default {
    components: {
        AppLayout,
        Conversations,
        SendMessage,
        Friend,
        Message
    },
    data() {
        return {
            messages: [],
            loading: true
        };
    },
    
    methods: {
        getMessages() {
            if (!route().current("messenger"))
                axios
                    .get(window.location.href.split("/").pop() + "/messages")
                    .then(res => {
                        this.messages = _.orderBy(
                            res.data,
                            ["created_at"],
                            ["asc"]
                        );
                        this.loading = false;
                        var el = this.$el.getElementsByClassName("bottom")[0];
                        setTimeout(function() {
                            el.scrollIntoView({ behavior: "smooth" });
                        }, 500);
                    })

                    .catch(err => {
                        console.log(err);
                    });
        },
        sendMessage(text, conversation_id) {
            let message = { text, conversation_id };
            axios
                .post("/messages", message)
                .then(res => {
                    this.messages.push(res.data);
                    var el = this.$el.getElementsByClassName("bottom")[0];
                    el.scrollIntoView({ behavior: "smooth" });
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
    mounted() {
        this.getMessages();
    }
};
</script>

<style>
.regular-conversations-height {
    height: calc(100vh - 190px);
}
.regular-messages-height {
    height: calc(100vh - 230px);
}
.messages::-webkit-scrollbar {
    width: 5px;
}

.messages::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.messages::-webkit-scrollbar-thumb {
    background: #e5e7eb;
}

.messages::-webkit-scrollbar-thumb:hover {
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
