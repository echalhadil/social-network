<template>
    <app-layout>
        <div class="w-full bg-gray-100 pb-10">
            <div class="w-11/12 bg-white mx-auto mt-6 shadow rounded-lg">
                <!-- cover -->
                <div class=" w-full h-64 ">
                    <friendship :profilerid="$page.profiler.id" />

                    <img
                        class="w-full rounded-lg h-full object-cover p-1 "
                        src="https://i.pinimg.com/564x/d8/5f/45/d85f454c5884b1a0acbe576574f4b840.jpg"
                    />
                </div>

                <div class=" w-full  ">
                    <div class=" w-36 h-36  mx-auto -mt-20 bg-transparent ">
                        <img
                            class=" w-full h-full object-cover shadow-lg bg-transparent  rounded-full "
                            :src="'/' + $page.profiler.picture"
                        />

                        <update-profile-picture
                            v-if="$page.user.id == $page.profiler.id"
                            :user="$page.profiler"
                            @update-profile-picture="updateProfilePicture"
                            @delete-profile-picture="deleteProfilePicture"
                        />
                    </div>
                    <!-- full name -->
                    <div class=" text-center p-2 ">
                        <p class=" text-2xl capitalize font-bold ">
                            {{ $page.profiler.firstname }}
                            {{ $page.profiler.lastname }}
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="w-11/12 mx-auto bg-white p-1 sm:p-0 mt-6 flex shadow rounded-lg capitalize"
            >
                <div
                    @click="show('timeline')"
                    class="w-1/4 text-center sm:m-2 p-2 rounded cursor-pointer"
                    :class="
                        'timeline' == currentsection
                            ? 'bg-indigo-500 hover:bg-indigo-400 text-white'
                            : 'hover:text-indigo-500 text-gray-700 '
                    "
                >
                    <i class="fal fa-stream fa-2x"></i>
                    <p>timeline</p>
                </div>

                <div
                    @click="show('friends')"
                    class="w-1/4 text-center sm:m-2 p-2 rounded cursor-pointer"
                    :class="
                    currentsection == 'friends' ?
                        'bg-indigo-500 hover:bg-indigo-400 text-white':
                        'hover:text-indigo-500 text-gray-700 '                
                "
                >
                    <i class="fal fa-users fa-2x" aria-hidden="true"></i>
                    <p>friends</p>
                </div>

                <div
                    @click="show('pictures')"
                    :class="{
                        'bg-indigo-500 hover:bg-indigo-400 text-white':
                            currentsection == 'pictures',
                        'hover:text-indigo-500 text-gray-700 ':
                            currentsection != 'pictures',
                        'w-1/4 text-center sm:m-2 p-2 rounded cursor-pointer': true
                    }"
                >
                    <i class="fal fa-images fa-2x  "></i>
                    <p>pictures</p>
                </div>

                <div
                    @click="show('settings')"
                    :class="{
                        'bg-indigo-500 hover:bg-indigo-400 text-white':
                            currentsection == 'settings',
                        'hover:text-indigo-500 text-gray-700 ':
                            currentsection != 'settings',
                        'w-1/4 text-center sm:m-2 p-2 rounded cursor-pointer': true
                    }"
                >
                    <i
                        class="fal fa-2x"
                        :class="{
                            'fa-cogs': $page.profiler.id == $page.user.id,
                            ' fa-info-circle':
                                $page.profiler.id != $page.user.id
                        }"
                        aria-hidden="true"
                    ></i>
                    <p v-if="$page.profiler.id == $page.user.id">settings</p>
                    <p v-if="$page.profiler.id != $page.user.id">about</p>
                </div>
            </div>

            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <timeline :timelineClasses="timelineClasses" />

            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <pictures
                :picturesClasses="picturesClasses"
                :posts="$page.profiler.posts"
            />

            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <friends
                :friendsClasses="friendsClasses"
                :posts="$page.profiler.posts"
            />

            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <settings :settingsClasses="settingsClasses" />

            <!-- ---------------------------------------------------------------------------------------------------------- -->
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
// import JetSectionBorder from '@/Jetstream/SectionBorder'
// import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
// import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
import UpdateProfilePicture from "./UpdateProfilePicture";
// iport sweet alert
import swal from "sweetalert";
import JetDropdown from "@/Jetstream/Dropdown";

import Friendship from "./Friendship";
import Timeline from "./Timeline";
import Friends from "./Friends";
import Pictures from "./Pictures";
import Settings from "./Settings";

export default {
    // props: ['sessions'],

    components: {
        AppLayout,
        UpdateProfilePicture,
        JetDropdown,
        Friendship,
        Timeline,
        Friends,
        Pictures,
        Settings

        // JetSectionBorder,
        // LogoutOtherBrowserSessionsForm,
        // TwoFactorAuthenticationForm,
    },
    data() {
        return {
            posts: [],
            comment: { text: null, post_id: null },
            timelineClasses: "w-11/12 mx-auto mt-6 flex rounded-lg capitalize",
            friendsClasses:
                "w-11/12 min-h-screen mx-auto hidden mt-6 rounded-lg capitalize",
            picturesClasses:
                "w-11/12 min-h-screen mx-auto hidden mt-6 rounded-lg capitalize",
            settingsClasses:
                "w-11/12 min-h-screen mx-auto hidden mt-6 rounded-lg capitalize",
            currentsection: "timeline"
        };
    },
    methods: {
        show(section) {
            this.currentsection = section;
            if (section == "timeline") {
                this.timelineClasses =
                    "w-11/12 mx-auto mt-6 flex rounded-lg capitalize";
                this.friendsClasses =
                    "w-11/12  mx-auto hidden mt-6 rounded-lg capitalize";
                this.settingsClasses = this.picturesClasses = this.friendsClasses;
            }
            if (section == "pictures") {
                this.timelineClasses =
                    "w-11/12 mx-auto hidden mt-6 rounded-lg capitalize";
                this.settingsClasses = this.friendsClasses = this.timelineClasses;
                this.picturesClasses =
                    "w-11/12 min-h-screen mx-auto flex mt-6 rounded-lg capitalize";
            }

            if (section == "friends") {
                this.timelineClasses =
                    "w-11/12 mx-auto hidden mt-6 rounded-lg capitalize";
                this.friendsClasses =
                    "w-11/12 min-h-screen mx-auto flex mt-6 rounded-lg capitalize";
                this.picturesClasses = this.settingsClasses = this.timelineClasses;
            }
            if (section == "settings") {
                this.timelineClasses =
                    "w-11/12 mx-auto hidden mt-6 rounded-lg capitalize";
                this.friendsClasses = this.picturesClasses = this.timelineClasses;
                this.settingsClasses =
                    "w-11/12 min-h-screen mx-auto flex mt-6 rounded-lg capitalize";
            }
        },

        removecover() {
            swal({
                title: "Are you sure?",
                text:
                    "Once you unfriend, you will not be able to see they posts!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then(willDelete => {
                if (willDelete) {
                    swal("You Unfriend successfuly!", {
                        icon: "success"
                    });
                }
            });
        },

        removepicture() {
            swal({
                title: "Are you sure?",
                text: "Once you remove it, you will not be able to restore it!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then(willDelete => {
                if (willDelete) {
                    swal("Your Profile Picture Removed Successfuly!", {
                        icon: "success"
                    });
                }
            });
        },
        updateProfilePicture(user, picture) {
            user.picture = picture;
        },

        deleteProfilePicture(user, picture) {
            user.picture = picture;
        }

        // friendship stuff
    },

    mounted() {}
};
</script>

<style>
.target:hover .dropdown-menu {
    display: block;
}
</style>
