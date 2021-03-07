<template>
    <div class="p-2 mt-3">
        <!-- recive message -->
        <div class="flex">
            <img
                v-if="$page.user.id != message.from_id"
                src="https://i.pinimg.com/564x/cf/63/60/cf636099f5e41f4773c55c1a677c6326.jpg"
                class="h-10 w-10 rounded-full"
            />
            <div v-if="$page.user.id != message.from_id" class=" flex  w-full">
                <div
                    class=" shadow p-2 mx-2 bg-white rounded-t-lg rounded-r-lg max-width "
                >
                    <p class="text-gray-700 px-2 text-sm">
                        {{ message.text }}
                    </p>
                </div>
                <div
                    v-if="$page.user.id != message.from_id"
                    class="my-auto text-gray-500 mr-auto "
                >
                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                </div>
            </div>
        </div>

        <div
            v-if="$page.user.id != message.from_id"
            class="capitalize ml-12 mt-1"
        >
            <p class=" text-xs text-gray-500 ">{{ message.timeago }}.</p>
        </div>

        <!-- sent message -->

        <div class="flex w-full">
            <div
                v-if="$page.user.id == message.from_id"
                class=" ml-auto my-auto text-gray-400"
            >
                <i
                    class=" ml-auto my-auto fa fa-ellipsis-h"
                    aria-hidden="true"
                ></i>
            </div>
            <div
                v-if="$page.user.id == message.from_id"
                class="my-auto mx-2 flex max-width"
            >
                <div
                    class="ml-auto my-auto p-2 shadow bg-indigo-500 rounded-t-lg rounded-l-lg "
                >
                    <p class="text-white text-sm">
                        {{ message.text }}
                    </p>
                </div>
            </div>

            <img
                v-if="$page.user.id == message.from_id"
                src="https://i.pinimg.com/564x/cf/63/60/cf636099f5e41f4773c55c1a677c6326.jpg"
                class="h-10 w-10 rounded-full "
            />
        </div>

        <div
            v-if="$page.user.id == message.from_id"
            class="w-full ml-auto capitalize mt-1"
        >
            <span class="float-right text-xs text-gray-500 mr-12"
                >{{ message.timeago }}.</span
            >
        </div>
    </div>
</template>

<script>
export default {
    props: ["message"]
};
</script>

<style>
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

.max-width {
    max-width: 75%;
}
</style>
