<template>
    <div
        class=" cursor-pointer hover:text-indigo-700 mx-auto"
        >
        <jet-dropdown align="left" width="72">
            <template #trigger>
                <i class=" far fa-user-friends" @click="newFriendRequest = 0">
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
</template>

<script>
import JetDropdown from "@/Jetstream/Dropdown";
export default {
    components:{
        JetDropdown,
    },
    
    data() {
        return {
            friendsRequest:[],
            newFriendRequest:0,
        }
    },
    methods: {
        playSound() {
            var soundurl =
                "https://assets.mixkit.co/sfx/preview/mixkit-home-standard-ding-dong-109.mp3";
            var audio = new Audio(soundurl);
            audio.play();
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

    },
    mounted() {

        this.getFriendsRequest();
        
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

    },



}
</script>