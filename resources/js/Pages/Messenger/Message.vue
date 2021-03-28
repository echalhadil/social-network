<template>
    <div class="p-2 mt-1">
        <!-- recive message -->
        <div class="flex">
            
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
                   
                        <jet-dropdown align="right" width="auto" class="ml-auto">
                            <template class="" #trigger>
                                 <i class="fa cursor-pointer fa-ellipsis-h" aria-hidden="true"></i>
                            </template>

                            <template #content>
                                <div
                                     @click="deleteMessage(message.id)"
                                    class="p-2 flex hover:text-indigo-500 cursor-pointer"
                                >
                                    <i
                                        class="fal my-auto fa-trash-alt pr-1"
                                        aria-hidden="true"
                                    ></i>
                                    delete
                                </div>
                            </template>
                        </jet-dropdown>
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
                <jet-dropdown align="right" width="auto" class="ml-auto">
                    <template class="" #trigger>
                            <i class="fa cursor-pointer fa-ellipsis-h" aria-hidden="true"></i>
                    </template>

                    <template #content>
                        <div
                            @click="deleteMessage(message.id)"
                            class="p-2 flex hover:text-indigo-500 cursor-pointer"
                        >
                            <i
                                class="fal my-auto fa-trash-alt pr-1"
                                aria-hidden="true"
                            ></i>
                            delete
                        </div>
                    </template>
                </jet-dropdown>
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
import JetDropdown from "@/Jetstream/Dropdown";
import Swal from "sweetalert";
export default {
    components:{
        JetDropdown,
    },
    props: ["message"],

    methods: {
        deleteMessage(id){

              swal({
                title: "Are you sure?",
                text:
                    "Once deleted, you will not be able to recover this message",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then(willDelete => {
                if (willDelete) {
                    swal("Your message has been deleted!", {
                        icon: "success",
                        button: "close"
                    });

                    axios
                        .delete("/messages/" + id)
                        .then(response => {
                            console.log(response.data);
                            this.$emit('delete-message', id)
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
            });

        },
        
    },
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
