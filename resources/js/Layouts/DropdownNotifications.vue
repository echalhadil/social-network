<template>
    <div class="cursor-pointer hover:text-indigo-700 mx-auto">
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
                        {{ newNotifications > 9 ? "9+" : newNotifications }}
                    </b>
                </i>
            </template>

            <template #content>
                <div class="block px-4 py-2 text-sm text-gray-400">
                    Notifications
                </div>

                <div class="border-t border-gray-100"></div>
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
                                :src="'/' + notification.maker.picture"
                                class=" h-12 w-12 rounded-full "
                            />
                        </div>
                        <div class=" pl-1 text-left pr-0.5  ">
                            <p
                                class=" float-left text-gray-700 text-xs font-bold "
                            >
                                {{ notification.maker.firstname }}
                                {{ notification.maker.lastname }}
                                <span class=" font-normal text-xs ">
                                    {{
                                        notification.type == "c"
                                            ? " commented on your post."
                                            : ""
                                    }}
                                    {{
                                        notification.type == "r"
                                            ? " reacted to your post."
                                            : ""
                                    }}
                                    {{
                                        notification.type == "f"
                                            ? " accepted your friend request."
                                            : ""
                                    }}
                                </span>
                            </p>
                            <p class=" text-xs ">
                                {{ notification.timeago }}
                            </p>
                        </div>
                        <div v-if="!notification.readed" class=" ml-auto">
                            <i
                                class="fa fa-circle circle text-indigo-500 fa-xs"
                                aria-hidden="true"
                            ></i>
                        </div>
                    </div>
                </div>
            </template>
        </jet-dropdown>


    <!--notification stuff -->

        <div v-if="showDroppingNotification"  class=" fixed bottom-0 m-3 right-0 bg-white hover:bg-gray-200 shadow-md rounded-lg ">
            <div class=" px-2 py-4 capitalize flex hover:bg-gray-100 rounded-md ">
                <div class=" h-12 w-12 ">
                    <img :src="'/'+DroppingNotification.maker.picture" class=" h-12 w-12 rounded-full " >
                </div>
                <div class=" pl-1 text-left  ">
                    <p class=" float-left  text-sm pr-1 "> 
                    {{DroppingNotification.maker.firstname}} {{DroppingNotification.maker.lastname}} 
                    </p>
                    <p class=" text-gray-700 text-sm ">
                       {{
                                        DroppingNotification.type == "c"
                                            ? " commented on your post."
                                            : ""
                                    }}
                                    {{
                                        DroppingNotification.type == "r"
                                            ? " reacted to your post."
                                            : ""
                                    }}
                                    {{
                                        DroppingNotification.type == "f"
                                            ? " accepted your friend request."
                                            : ""
                                    }}
                    </p>
                  
                    
                </div>
                <div @click="showDroppingNotification = false" class=" my-auto rounded-full p-2.5 text-center text-gray-600 py-0.5 hover:bg-gray-300 ">
                    <i class="fa fa-times h-2 w-2" ></i>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import JetDropdown from "@/Jetstream/Dropdown";

export default {
    components: {
        JetDropdown
    },
    data() {
        return {
            notifications: [],
            showDroppingNotification : false,
            DroppingNotification :{
            },
            newNotifications: 0
        };

    },
    methods: {
        playSound() {
            var soundurl =
                "https://assets.mixkit.co/sfx/preview/mixkit-home-standard-ding-dong-109.mp3";
            var audio = new Audio(soundurl);
            audio.play();
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
        }
    },
    mounted() {
        this.getNotifications();
        Echo.channel("notification-channel-" + this.user_id).listen(
            ".NotificationEvent",
            data => {
                let notification = data.notification;
                console.table(notification);
                this.notifications.unshift(notification);
                this.DroppingNotification = notification;
                this.showDroppingNotification = true;

                this.newNotifications++;


                this.playSound();
            }
        );
    }
};
</script>
