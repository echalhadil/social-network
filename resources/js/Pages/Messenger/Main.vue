<template>
    <app-layout>
        <div class="flex mt-6 mx-3 ">
            <div
                class=" mx-auto w-full sm:w-1/4 regular-conversations-height  "
            >
                <div class="w-full p-2">
                    <p class="capitalize text-lg font-semibold">conversation</p>
                </div>

                <div class="px-2 py-1">
                    <input
                        type="text"
                        placeholder="Search Here"
                        class="focus:outline-none focus:ring-2 focus:border-indigo-500 ml-auto bg-transparent h-10 capitalize w-full border-gray-300 border rounded-md "
                    />
                </div>

                <conversations />
            </div>

            <div
                class=" regular-messages-height w-0 invisible sm:w-2/4 sm:visible  "
            >
                <div class=" w-full px-2 py-3 bg-white flex shadow-lg">
                    <div class=" pr-1 ">
                        <img
                            src="https://i.pinimg.com/564x/cf/63/60/cf636099f5e41f4773c55c1a677c6326.jpg"
                            class="w-10 h-10 rounded-full"
                        />
                    </div>
                    <div class=" capitalize my-auto ">
                        <p class=" font-bold text-lg ">Echalh Adil</p>
                        <p class=" text-sm text-gray-500 ">online</p>
                    </div>
                </div>

                <div class=" w-full h-full messages overflow-auto mt-3 ">
                    <!-- loading for message -->
                    <div>
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

                    <div class="p-2 flex">
                        <img
                            src="https://i.pinimg.com/564x/cf/63/60/cf636099f5e41f4773c55c1a677c6326.jpg"
                            class="h-10 w-10 rounded-full"
                        />
                        <div class="ml-2 w-3/4">
                            <div
                                class=" shadow p-2 bg-white rounded-t-lg rounded-r-lg  w-full "
                            >
                                <p class="text-gray-700 text-sm">
                                    Un texte est une série orale ou écrite de
                                    mots perçus comme constituant un ensemble
                                    cohérent, porteur de sens et utilisant les
                                    structures propres à une langue. Un texte
                                    n'a pas de longueur déterminée sauf dans le
                                    cas de poèmes à forme fixe comme le sonnet
                                    ou le haïku.
                                </p>
                            </div>
                            <div class="capitalize mt-1">
                                <p class=" text-xs text-gray-500 ">
                                    sent 1s ago.
                                </p>
                            </div>
                        </div>
                        <div class="my-auto ml-auto text-gray-600 mr-auto ">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="p-2 flex">
                        <div class="my-auto ml-auto text-gray-600">
                            <i
                                class=" ml-auto fa fa-ellipsis-h"
                                aria-hidden="true"
                            ></i>
                        </div>

                        <div class="ml-auto w-3/4 ">
                            <div
                                class="ml-auto p-2 shadow bg-indigo-500 rounded-t-lg rounded-l-lg  w-full "
                            >
                                <p class="text-white text-sm">
                                    Un texte est une série orale ou écrite de
                                    mots perçus comme constituant un ensemble
                                    cohérent, porteur de sens et utilisant les
                                    structures propres à une langue. Un texte
                                    n'a pas de longueur déterminée sauf dans le
                                    cas de poèmes à forme fixe comme le sonnet
                                    ou le haïku.
                                </p>
                            </div>
                            <div class="w-3/4 ml-auto capitalize mt-1">
                                <p class="float-right text-xs text-gray-500 ">
                                    sent 1s ago.
                                </p>
                            </div>
                        </div>

                        <img
                            src="https://i.pinimg.com/564x/cf/63/60/cf636099f5e41f4773c55c1a677c6326.jpg"
                            class="h-10 w-10 rounded-full ml-2"
                        />
                    </div>

                    <div class="p-2 flex">
                        <img
                            src="https://i.pinimg.com/564x/cf/63/60/cf636099f5e41f4773c55c1a677c6326.jpg"
                            class="h-10 w-10 rounded-full"
                        />
                        <div class="ml-2 w-3/4">
                            <div
                                class=" shadow p-2 bg-white rounded-t-lg rounded-r-lg  w-full "
                            >
                                <p class="text-gray-700 text-sm">
                                    Un texte est une série orale ou écrite de
                                    mots perçus comme constituant un ensemble
                                    cohérent, porteur de sens et utilisant les
                                    structures propres à une langue. Un texte
                                    n'a pas de longueur déterminée sauf dans le
                                    cas de poèmes à forme fixe comme le sonnet
                                    ou le haïku.
                                </p>
                            </div>
                            <div class="capitalize mt-1">
                                <p class=" text-xs text-gray-500 ">
                                    sent 1s ago.
                                </p>
                            </div>
                        </div>
                        <div class="my-auto ml-auto text-gray-600 mr-auto ">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="p-2 flex">
                        <div class="my-auto ml-auto text-gray-600">
                            <i
                                class=" ml-auto fa fa-ellipsis-h"
                                aria-hidden="true"
                            ></i>
                        </div>

                        <div class="ml-auto w-3/4 ">
                            <div
                                class="ml-auto p-2 shadow bg-indigo-500 rounded-t-lg rounded-l-lg  w-full "
                            >
                                <p class="text-white text-sm">
                                    Un texte est une série orale ou écrite de
                                    mots perçus comme constituant un ensemble
                                    cohérent, porteur de sens et utilisant les
                                    structures propres à une langue. Un texte
                                    n'a pas de longueur déterminée sauf dans le
                                    cas de poèmes à forme fixe comme le sonnet
                                    ou le haïku.
                                </p>
                            </div>
                            <div class="w-3/4 ml-auto capitalize mt-1">
                                <p class="float-right text-xs text-gray-500 ">
                                    sent 1s ago.
                                </p>
                            </div>
                        </div>

                        <img
                            src="https://i.pinimg.com/564x/cf/63/60/cf636099f5e41f4773c55c1a677c6326.jpg"
                            class="h-10 w-10 rounded-full ml-2"
                        />
                    </div>
                </div>

                <send-message />
            </div>

            <div class="mx-2 w-0 invisible sm:w-1/4 sm:visible">
                <div class="p-2 bg-white w-full rounded-lg">
                    <div class="  ">
                        <img
                            src="https://i.pinimg.com/564x/8c/1c/ec/8c1cec6ab839e0266066407528d12d69.jpg"
                            class="mx-auto h-28 w-28 object-cover rounded-full "
                        />
                    </div>
                    <div class=" text-center mt-1">
                        <p class=" text-xl font-bold ">Echalh Adil</p>
                        <p class=" text-md  ">@echalhadil</p>
                    </div>

                    <div
                        class="flex mx-auto w-11/12  text-center mt-3 p-2 hover:bg-gray-50 hover:text-indigo-500"
                    >
                        <i
                            class=" ml-auto fal fa-user my-auto"
                            aria-hidden="true"
                        ></i>
                        <p class="my-auto mr-auto ml-1 capitalize  ">
                            view profile
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Conversations from "./Conversations";
import SendMessage from "./SendMessage";

export default {
    components: {
        AppLayout,
        Conversations,
        SendMessage
    },
    data() {
        return {
            messages: []
        };
    },
    methods: {
        getMessages() {
            axios
                .get("messages")
                .then(res => {
                    this.messages = _.orderBy(
                        res.data,
                        ["created_at"],
                        ["asc"]
                    );
                })

                .catch(err => {
                    console.log(err);
                });
        }
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
