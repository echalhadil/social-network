<template>
    <div>
        <div
            class=" rounded-full target -mt-8 mr-6 border  text-black float-right hover:bg-gray-100  hover:text-gray-800 cursor-pointer bg-white relative top-0 "
        >
            <i class="fal fa-pencil p-1" aria-hidden="true"></i>

            <!--profile picture option -->
            <div
                class=" border border-grey-100 hidden px-3 p-2 capitalize text-gray-800  dropdown-menu  absolute bg-white rounded "
            >
                <div
                    @click="confirmingUserDeletion = true"
                    class="hover:text-indigo-500 flex py-1"
                >
                    <i class="fal fa-pencil pr-2" aria-hidden="true"></i>
                    <p class=" ">edit</p>
                </div>

                <div
                    v-if="user.picture != 'images/users/male_user.jpg'"
                    @click="deleteProfilePicture"
                    class=" hover:text-indigo-500 flex py-1"
                >
                    <i class="fal fa-trash pr-2" aria-hidden="true"></i>
                    <p class="">remove</p>
                </div>
            </div>
            <!--profile picture option -->
        </div>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal
            :show="confirmingUserDeletion"
            @close="confirmingUserDeletion = false"
            >
            <template #title>
                Update Profile Picture
            </template>

            <template #content>
                <div class="mt-4">
                    <label
                        for="input-profile-picture"
                        roll="input"
                        type="file"
                        class=" cursor-pointer flex bg-cool-gray-200 hover:bg-gray-300 p-2 rounded "
                    >
                        <i class="my-auto fal fa-image"></i>
                        <p class=" capitalize my-auto ml-1">Photo</p>
                    </label>
                    <input
                        id="input-profile-picture"
                        accept="image/*"
                        v-on:change="uploadfile"
                        type="file"
                        name="picture"
                        class=" hidden "
                    />
                </div>

                <div v-if="preview_image != ''" class="pl-3 mt-5 ">
                    <i
                        class=" rounded-full bg-cool-gray-300 hover:bg-cool-gray-200 -ml-2 -mt-2 border  px-1 py-0.5 float-right mb-1 absolute text-gray-800 fal fa-times cursor-pointer"
                        v-on:click="preview_image = ''"
                        type="button"
                    ></i>
                    <img
                        class=" md:w-2/3 w-full h-72 object-cover rounded-sm"
                        :src="preview_image"
                    />
                </div>
            </template>

            <template #footer>
                <jet-secondary-button
                    @click.native="confirmingUserDeletion = false"
                >
                    Cancel
                </jet-secondary-button>

                <button
                    @click="updateProfilePicture"
                    class="ml-2 px-4 py-2 ring shadow border rounded-md bg-indigo-500 text-white  hover:text-indigo-500 hover:bg-gray-50"
                    :class="{ 'opacity-50': preview_image == '' }"
                    :disabled="preview_image == ''"
                >
                    Update
                </button>

                <!-- message -->
                <div
                    v-if="message.visible"
                    class="relative float-left py-2 pl-4 pr-10 leading-normal rounded-lg  "
                    :class="{
                        'text-green-700 bg-green-100': message.type,
                        'text-red-700 bg-red-100': !message.type
                    }"
                    role="alert"
                >
                    <p class=" capitalize ">{{ message.content }}</p>
                    <span
                        class="absolute inset-y-0 right-0 flex items-center mr-4"
                    >
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
</template>

<script>
import JetActionSection from "@/Jetstream/ActionSection";
import JetDialogModal from "@/Jetstream/DialogModal";
import JetDangerButton from "@/Jetstream/DangerButton";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetSecondaryButton from "@/Jetstream/SecondaryButton";

// iport sweet alert
import swal from "sweetalert";

export default {
    components: {
        JetActionSection,
        JetDangerButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton
    },
    props: ["user"],

    data() {
        return {
            confirmingUserDeletion: false,
            picture: "",
            preview_image: "",
            message: {
                type: "success",
                content: "profile picture has been updated successfuly!",
                visible: false
            }
        };
    },
    methods: {
        confirmUserDeletion() {
            this.confirmingUserDeletion = true;
        },
        uploadfile() {
            const reader = new FileReader();

            reader.readAsDataURL(
                document.getElementById("input-profile-picture").files[0]
            );

            this.picture = document.getElementById(
                "input-profile-picture"
            ).files[0];

            reader.onload = () => {
                this.preview_image = reader.result;
            };
        },
        updateProfilePicture() {
            var formData = new FormData();
            formData.set("user_id", this.user.id);
            formData.append("picture", this.picture);

            axios
                .post(this.user.id + "/updateprofilepicture", formData, {
                    headers: { "Content-Type": "multipart/form-data" }
                })
                .then(response => {
                    this.$emit(
                        "update-profile-picture",
                        this.user,
                        response.data
                    );
                    this.message = {
                        type: "success",
                        content:
                            "profile picture has been updated successfuly!",
                        visible: true
                    };
                    this.preview_image = "";
                    setTimeout(() => {
                        this.confirmingUserDeletion = false;
                        this.message.visible = false;
                    }, 1000);
                })
                .catch(error => {
                    console.log(error);
                    this.message = {
                        type: "error",
                        content: "something wrong please try again!",
                        visible: true
                    };
                    this.preview_image = "";
                });
        },

        deleteProfilePicture() {
            swal({
                title: "Are you sure?",
                text:
                    "Once you unfriend, you will not be able to see they posts!",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then(willDelete => {
                if (willDelete) {
                    axios
                        .post(this.user.id + "/deleteprofilepicture")
                        .then(response => {
                            console.log(response.data);
                            this.$emit(
                                "delete-profile-picture",
                                this.user,
                                response.data
                            );

                            swal("You Unfriend successfuly!", {
                                icon: "success"
                            });
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
            });
        }
    }
};
</script>

<style>
.target:hover .dropdown-menu {
    display: block;
}
</style>
