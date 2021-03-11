<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b fixed w-full border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex w-full">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <inertia-link :href="route('main')">
                                <jet-application-mark
                                    class="block h-9 w-auto"
                                />
                            </inertia-link>
                        </div>

                        <!-- Navigation Links -->
                        <div
                            class="hidden  w-1/2 space-x-8 sm:-my-px sm:ml-10 sm:flex"
                        >
                            <!--<jet-nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                                Dashboard
                            </jet-nav-link>
                            -->

                            <input
                                v-on:keyup.enter="search"
                                placeholder="type here to search..."
                                class="focus:outline-none focus:ring-2 focus:border-indigo-500  bg-gray-100 ml-auto h-12 capitalize my-auto w-10/12 border-blue-100 border-2 rounded-lg "
                                type="text"
                            />
                        </div>

                        <div
                            class="flex-shrink-0 flex text-indigo-500 md:ml-auto mx-auto md:w-1/3 w-2/3 items-center"
                        >
                            <inertia-link
                                :href="route('main')"
                                :class="{
                                    'border-indigo-500 border-b ': route().current(
                                        'main'
                                    )
                                }"
                                class=" cursor-pointer hover:text-indigo-700  mx-auto"
                            >
                                <i class="far fa-home" aria-hidden="true"></i>
                            </inertia-link>

                            <!--friends request -->
                            <div
                                class=" cursor-pointer hover:text-indigo-700 mx-auto"
                            >
                                <jet-dropdown align="left" width="72">
                                    <template #trigger>
                                        <i class=" far fa-user-friends">
                                            <b
                                                v-if="newFriendRequest != 0"
                                                class=" fixed w-3 p-0.5 -ml-1 -mt-2 text-center text-white text-xs bg-red-600 rounded-full "
                                            >
                                                {{
                                                    newFriendRequest > 9
                                                        ? "9+"
                                                        : newFriendRequest
                                                }}
                                            </b>
                                        </i>
                                    </template>

                                    <template #content>
                                        <div
                                            class="block px-4 py-2 text-sm text-gray-400"
                                        >
                                            Friendship Requests
                                        </div>

                                        <div
                                            class="border-t border-gray-100"
                                        ></div>

                                        <div
                                            v-if="friendsRequest.length == 0"
                                            class="px-4 text-gray-400 text-center "
                                        >
                                            <i
                                                class="fa mt-7 fa-3x fa-user-times"
                                                aria-hidden="true"
                                            ></i>
                                            <p class=" mb-7 mt-3 text-sm  ">
                                                No Requests
                                            </p>
                                        </div>

                                        <div
                                            v-if="friendsRequest.length > 0"
                                            class="dropdown  overflow-auto h-64 text-gray-400 text-center "
                                        >
                                            <div
                                                v-for="friendRequest in friendsRequest"
                                                :key="friendRequest.id"
                                                class="p-2 capitalize flex hover:bg-gray-100 rounded-md "
                                            >
                                                <inertia-link
                                                    :href="
                                                        'profiles/' +
                                                            friendRequest.maker
                                                                .id
                                                    "
                                                    class=" h-13 w-13"
                                                >
                                                    <img
                                                        :src="
                                                            '/' +
                                                                friendRequest
                                                                    .maker
                                                                    .picture
                                                        "
                                                        class=" h-12 w-12 rounded-full "
                                                    />
                                                </inertia-link>
                                                <div
                                                    class=" pl-1 text-left pr-0.5  "
                                                >
                                                    <p
                                                        class=" text-sm text-gray-700 font-bold "
                                                    >
                                                        {{
                                                            friendRequest.maker
                                                                .firstname
                                                        }}
                                                        {{
                                                            friendRequest.maker
                                                                .lastname
                                                        }}
                                                        <!--<span class=" font-normal text-xs ">sent you friend request.</span> -->
                                                    </p>

                                                    <div class=" text-sm">
                                                        <button
                                                            @click="
                                                                confirmFriendRequest(
                                                                    friendRequest
                                                                )
                                                            "
                                                            class="capitalize font-bold mr-0.5 px-4 py-2 bg-indigo-500 hover:bg-indigo-400 rounded-lg text-white "
                                                        >
                                                            confirm
                                                        </button>
                                                        <button
                                                            @click="
                                                                deletFriendRequest(
                                                                    friendRequest.id
                                                                )
                                                            "
                                                            class="capitalize font-bold ml-0.5 px-4 py-2 rounded-lg bg-cool-gray-100 hover:bg-cool-gray-200 text-gray-800 "
                                                        >
                                                            delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </jet-dropdown>
                            </div>

                            <!--notifications -->
                            <div
                                class="cursor-pointer hover:text-indigo-700 mx-auto"
                            >
                                <div v-if="(user_id = $page.user.id)"></div>
                                <jet-dropdown align="right" width="72">
                                    <template #trigger>
                                        <i
                                            v-on:click="seeNotifications"
                                            class="far fa-bell"
                                            aria-hidden="true"
                                        >
                                            <b
                                                v-if="newNotifications != 0"
                                                class=" fixed w-3 p-0.5 -ml-1 -mt-2 text-center text-white text-xs bg-red-600 rounded-full "
                                                >
                                                {{
                                                    newNotifications > 9
                                                        ? "9+"
                                                        : newNotifications
                                                }}
                                            </b>
                                        </i>
                                    </template>

                                    <template #content>
                                        <div
                                            class="block px-4 py-2 text-sm text-gray-400"
                                        >
                                            Notifications 
                                            
                                        </div>

                                        <div
                                            class="border-t border-gray-100"
                                        ></div>
                                        <!-- no notifications -->
                                        <div
                                            v-if="notifications.length === 0"
                                            class="px-4 text-gray-400 text-center "
                                        >
                                            <i
                                                class="fa mt-7 fa-3x fa-bell-slash"
                                                aria-hidden="true"
                                            ></i>
                                            <p class=" mb-7 mt-3 text-sm  ">
                                                No Notifications
                                            </p>
                                        </div>

                                        <div
                                            v-if="notifications.length > 0"
                                            class="dropdown  overflow-auto h-64 text-gray-400 text-center "
                                        >
                                            <div
                                                v-for="notification in notifications"
                                                :key="notification.id"
                                                class=" p-2 capitalize flex hover:bg-gray-100 rounded-md "
                                            >
                                                <div class=" w-1/4">
                                                    <img
                                                        :src="
                                                            '/' +
                                                                notification
                                                                    .maker
                                                                    .picture
                                                        "
                                                        class=" h-12 w-12 rounded-full "
                                                    />
                                                </div>
                                                <div
                                                    class=" pl-1 text-left pr-0.5  "
                                                >
                                                    <p
                                                        class=" float-left text-gray-700 text-xs font-bold "
                                                    >
                                                        {{
                                                            notification.maker
                                                                .firstname
                                                        }}
                                                        {{
                                                            notification.maker
                                                                .lastname
                                                        }}
                                                        <span
                                                            class=" font-normal text-xs "
                                                        >
                                                            {{
                                                                notification.type ==
                                                                "c"
                                                                    ? " commented on your post."
                                                                    : ""
                                                            }}
                                                            {{
                                                                notification.type ==
                                                                "r"
                                                                    ? " reacted to your post."
                                                                    : ""
                                                            }}
                                                            {{
                                                                notification.type ==
                                                                "f"
                                                                    ? " accepted your friend request."
                                                                    : ""
                                                            }}
                                                        </span>
                                                    </p>
                                                    <p class=" text-xs ">
                                                        {{
                                                            notification.timeago
                                                        }}
                                                    </p>
                                                </div>
                                                <div
                                                    v-if="!notification.readed"
                                                    class=" ml-auto"
                                                >
                                                    <i
                                                        class="fa fa-circle circle text-indigo-500 fa-xs"
                                                        aria-hidden="true"
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </jet-dropdown>
                            </div>

                            <!--messages -->
                            <div
                                class="cursor-pointer hover:text-indigo-700 mx-auto "
                            >
                                <jet-dropdown align="right" width="72">
                                    <template #trigger>
                                        <i v-on:click="newConversations=0"
                                            class="far fa-envelope"
                                            aria-hidden="true"
                                        >
                                        <b
                                                v-if="newConversations != 0"
                                                class=" fixed w-3 p-0.5 -ml-1 -mt-2 text-center text-white text-xs bg-red-600 rounded-full "
                                                >
                                                {{
                                                    newConversations > 9
                                                        ? "9+"
                                                        : newConversations
                                                }}
                                            </b>
                                        </i>
                                    </template>

                                    <template #content>
                                        <div
                                            class="block px-4 py-2 text-sm text-gray-400"
                                        >
                                            Conversations
                                            <inertia-link href="/messenger" class=" float-right text-xs text-indigo-500 font-semibold capitalize "> messenger </inertia-link>
                                        </div>

                                        <div
                                            class="border-t border-gray-100"
                                        ></div>
                                        <div
                                            v-if="conversations.length == 0"
                                            class="px-4 text-gray-400 text-center "
                                        >
                                            <i
                                                class="fa mt-7 fa-3x fa-comment-alt-slash"
                                                aria-hidden="true"
                                            ></i>
                                            <p class=" mb-7 mt-3 text-sm  ">
                                                No Conversations
                                            </p>
                                        </div>

                                        <div
                                            v-if="conversations.length > 0"
                                            class=" text-gray-400 text-sm h-64 "
                                        >
                                            <inertia-link
                                                v-for="conversation in conversations"
                                                :key="conversation.id"
                                                class=" p-2 flex hover:bg-gray-100 "
                                                :href="'/conversations/'+conversation.id"
                                            >
                                                <div>
                                                    <img
                                                        class=" h-12 w-12 rounded-full mr-1 my-auto "
                                                        :src="
                                                            '/' +
                                                                conversation
                                                                    .friend
                                                                    .picture
                                                        "
                                                    />
                                                </div>
                                                <div class="my-auto">
                                                    <p class=" font-bold text-gray-800 ">{{conversation.friend.firstname}} {{conversation.friend.lastname}} </p>
                                                    <p class="text-xs truncate float-left  text-gray-500">
                                                        {{
                                                            conversation.last_message
                                                        }} .
                                                        <span class=" float-right ml-1 text-gray-400 text-xs ">
                                                        {{
                                                            conversation.timeago
                                                        }}
                                                        </span>
                                                    </p>
                                                   
                                                </div>
                                                <div v-if="true" class="ml-auto my-auto">
                                                
                                                    <i class="fa circle fa-circle text-indigo-500 fa-xs    "></i>
                                                </div>
                                            </inertia-link>
                                        </div>
                                    </template>
                                </jet-dropdown>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="ml-3 relative">
                            <jet-dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        class="flex h-7 w-7 text-sm border-2 border-transparent rounded-full focus:outline-none
                                     hover:text-indigo-700 focus:text-indigo-100 transition duration-150 ease-in-out"
                                        :class="{
                                            'border-gray-500': !route().current(
                                                'profiles.show'
                                            ),
                                            'border-indigo-500': route().current(
                                                'profiles.show'
                                            )
                                        }"
                                    >
                                        <img
                                            class=" w-6 h-6 rounded-full object-cover"
                                            :src="'/' + $page.user.picture"
                                            :alt="$page.user.name"
                                        />
                                    </button>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div
                                        class="block px-4 py-2 text-xs text-gray-400"
                                    >
                                        Manage Account
                                    </div>

                                    <jet-dropdown-link
                                        :href="'/profiles/' + $page.user.id"
                                    >
                                        Profile
                                    </jet-dropdown-link>
                                    <div class="border-t border-gray-100"></div>

                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <jet-dropdown-link as="button">
                                            Logout
                                        </jet-dropdown-link>
                                    </form>
                                </template>
                            </jet-dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button
                            @click="
                                showingNavigationDropdown = !showingNavigationDropdown
                            "
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                        >
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown
                }"
                class="sm:hidden"
            >
                <div class="pt-2 pb-3 space-y-1">
                    <jet-responsive-nav-link
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                    >
                        Dashboard
                    </jet-responsive-nav-link>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <img
                                class="h-10 w-10 rounded-full"
                                :src="'/' + $page.user.picture"
                                :alt="$page.user.name"
                            />
                        </div>

                        <div class="ml-3">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.user.email }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <jet-responsive-nav-link
                            :href="route('profile.show')"
                            :active="route().current('profile.show')"
                        >
                            Profile
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link
                            :href="route('api-tokens.index')"
                            :active="route().current('api-tokens.index')"
                            v-if="$page.jetstream.hasApiFeatures"
                        >
                            API Tokens
                        </jet-responsive-nav-link>

                        <!-- Authentication -->
                        <form method="POST" @submit.prevent="logout">
                            <jet-responsive-nav-link as="button">
                                Logout
                            </jet-responsive-nav-link>
                        </form>

                        <!-- Team Management -->
                        <template v-if="$page.jetstream.hasTeamFeatures">
                            <div class="border-t border-gray-200"></div>

                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Manage Team
                            </div>

                            <!-- Team Settings -->
                            <jet-responsive-nav-link
                                :href="
                                    route('teams.show', $page.user.current_team)
                                "
                                :active="route().current('teams.show')"
                            >
                                Team Settings
                            </jet-responsive-nav-link>

                            <jet-responsive-nav-link
                                :href="route('teams.create')"
                                :active="route().current('teams.create')"
                            >
                                Create New Team
                            </jet-responsive-nav-link>

                            <div class="border-t border-gray-200"></div>

                            <!-- Team Switcher -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                Switch Teams
                            </div>

                            <template v-for="team in $page.user.all_teams">
                                <form
                                    @submit.prevent="switchToTeam(team)"
                                    :key="team.id"
                                >
                                    <jet-responsive-nav-link as="button">
                                        <div class="flex items-center">
                                            <svg
                                                v-if="
                                                    team.id ==
                                                        $page.user
                                                            .current_team_id
                                                "
                                                class="mr-2 h-5 w-5 text-green-400"
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                ></path>
                                            </svg>
                                            <div>{{ team.name }}</div>
                                        </div>
                                    </jet-responsive-nav-link>
                                </form>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <!--
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
                <slot name="header"></slot>
            </div>
        </header>
        -->
        <!-- Page Content -->
        <main class=" pt-15 ">
            <slot></slot>
        </main>

        <!-- Modal Portal -->
        <portal-target name="modal" multiple> </portal-target>

        <!--notification stuff -->
        <!--
        <div  class=" fixed bottom-0 m-3 right-0 bg-white hover:bg-gray-200 shadow-md rounded-lg ">
            <div class=" px-2 py-4 capitalize flex hover:bg-gray-100 rounded-md ">
                <div class=" h-12 w-12">
                    <img :src="'http://127.0.0.1:8000/'+$page.user.picture" class=" h-12 w-12 rounded-full " >
                </div>
                <div class=" pl-1 text-left  ">
                    <p class=" float-left  text-sm pr-1 "> 
                    {{$page.user.firstname}} {{$page.user.lastname}} 
                    </p>
                    <p class=" text-gray-700 text-sm ">
                        commented on your post.
                    </p>
                  
                    
                </div>
            </div>
        </div>
-->
    </div>
</template>

<script>
import JetApplicationMark from "@/Jetstream/ApplicationMark";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import JetNavLink from "@/Jetstream/NavLink";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";

export default {
    components: {
        JetApplicationMark,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink
    },

    data() {
        return {
            showingNavigationDropdown: false,
            notifications: [],
            friendsRequest: [],
            conversations: [],
            newNotifications: 0,
            newFriendRequest: 0,
            newConversations:0,
            user_id: ""
        };
    },

    methods: {
        switchToTeam(team) {
            this.$inertia.put(
                route("current-team.update"),
                {
                    team_id: team.id
                },
                {
                    preserveState: false
                }
            );
        },

        logout() {
            axios.post(route("logout").url()).then(response => {
                window.location = "/";
            });
        },

        getNotifications() {
            axios
                .get(route("notifications.index").url())
                .then(response => {
                    console.table(response.data);
                    this.notifications = _.orderBy(
                        response.data,
                        ["created_at"],
                        ["desc"]
                    );
                    this.newNotifications = response.data.filter(
                        n => n.seen === 0
                    ).length;

                    console.log(this.newNotifications);
                })
                .catch(err => {
                    console.table(err);
                });
        },

        playSound() {
            var soundurl =
                "https://assets.mixkit.co/sfx/preview/mixkit-home-standard-ding-dong-109.mp3";
            var audio = new Audio(soundurl);
            audio.play();
        },
        seeNotifications() {
            if (this.newNotifications != 0) {
                this.newNotifications = 0;
                axios
                    .get("/seenotifications")
                    .then(response => {
                        console.log(response);
                    })
                    .catch(err => {
                        console.log(err);
                    });
            }
        },

        getFriendsRequest() {
            axios
                .get(route("friendrequests.index"))
                .then(response => {
                    this.friendsRequest = response.data;
                    this.newFriendRequest = response.data.filter(
                        fr => fr.seen === 0
                    ).length;
                })
                .catch(err => {
                    console.log(err);
                });
        },

        deletFriendRequest(id) {
            axios
                .delete("/friendrequests/" + id)
                .then(response => {
                    console.log(response.data);
                    this.friendsRequest = this.friendsRequest.filter(
                        fr => fr.id != id
                    );
                })
                .catch(err => {
                    console.log(err);
                });
        },

        confirmFriendRequest(friendrequest) {
            axios
                .post("/friends/", friendrequest)
                .then(response => {
                    console.log(response.data);
                    this.friendsRequest = this.friendsRequest.filter(
                        fr => fr.id != friendrequest.id
                    );
                })
                .catch(err => {
                    console.log(err);
                });
        },

        search() {
            window.location = "/";
        },
        getConversations() {
            axios
                .get("/conversations")
                .then(res => {
                    this.conversations = _.orderBy(
                        res.data,
                        ["updated_at"],
                        ["desc"]
                    );
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
    computed: {
        countNewMessages() {}
    },
    mounted() {
        this.getNotifications();
        this.getFriendsRequest();
        this.getConversations();

        Echo.channel("notification-channel-" + this.user_id).listen(
            ".NotificationEvent",
            data => {
                let notification = data.notification;
                console.table(notification);
                this.notifications.unshift(notification);
                this.newNotifications++;
                this.playSound();
            }
        );

        Echo.channel("friend-request-channel-" + this.user_id).listen(
            ".FriendRequestEvent",
            data => {
                let friendRequest = data.friendrequest;
                console.table(friendRequest);
                this.friendsRequest.unshift(friendRequest);
                this.newFriendRequest++;

                this.playSound();
            }
        );

       
          Echo.channel("message-channel-" + this.$page.user.id).listen(
            ".MessageEvent",
            data => {
                let conversation = data.conversation;

              
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
                this.newConversations++;

                this.playSound();

                //    else
                //    this.conversations.unshift(conversation);
            }
        );
    }
};
</script>

<style>
.dropdown::-webkit-scrollbar {
    width: 3px;
}

.dropdown::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.dropdown::-webkit-scrollbar-thumb {
    background: #cfd0d1;
}

.dropdown::-webkit-scrollbar-thumb:hover {
    background: #555;
}
.circle{
        font-size: xx-small;
    }
</style>
