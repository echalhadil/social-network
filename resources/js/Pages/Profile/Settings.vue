<template>
    <div :class="settingsClasses">
        <div
            v-if="$page.profiler.id == $page.user.id"
            class=" w-full mx-auto bg-white shadow rounded-lg p-2"
        >
            <update-profile-information-form :user="$page.user" />
            <update-password-form class=" mt-6 " />
            <delete-user-form />
        </div>

        <div
            v-if="$page.profiler.id != $page.user.id"
            class=" w-full mx-auto bg-white shadow rounded-lg p-2"
        ></div>
    </div>
</template>

<script>
import UpdatePasswordForm from "./UpdatePasswordForm";
import DeleteUserForm from "./DeleteUserForm";
import UpdateProfileInformationForm from "./UpdateProfileInformationForm";
export default {
    props: ["settingsClasses"],
    components: {
        DeleteUserForm,
        UpdatePasswordForm,
        UpdateProfileInformationForm
    }
};
</script>
