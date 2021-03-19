<template>
    <div class="comments overflow-auto pt-3 mt-2  px-2">
        <div
            v-for="comment in comments"
            :key="comment.id"
            class="comments pb-2 flex"
        >
            <inertia-link
                :href="'/profiles/' + comment.user.id"
                class="pr-1"
            >
                <img
                    class=" h-11 w-11 rounded-full object-cover  "
                    :src="'/' + comment.user.picture"
                />
            </inertia-link>
            <div clafss=" pl-1  w-11/12 ">
                <inertia-link
                    :href="'/profiles/' + comment.user.id"
                    class=" capitalize font-semibold text-sm "
                >
                    {{ comment.user.firstname }}
                    {{ comment.user.firstname }}
                </inertia-link>
                <p class=" capitalize text-sm text-cool-gray-600  ">
                    {{ comment.text }}
                    <span class="px-1 text-xl font-bold ">.</span>
                    <span class=" text-teal-400">{{
                        comment.timeago
                    }}</span>
                </p>
            </div>
            <div class="ml-auto my-auto mr-4">
                <jet-dropdown align="right" width="32" class="ml-auto">
                    <template class="" #trigger>
                        <i
                            class="text-gray-400 cursor-pointer hover:text-gray-500 fa fa-ellipsis-h"
                            aria-hidden="true"
                        ></i>
                    </template>

                    <template #content>
                        <div
                            v-if="$page.user.id==comment.user.id"
                            class="p-2 flex  hover:text-indigo-500 cursor-pointer"
                        >
                            <i class="fal fa-pencil pr-1" aria-hidden="true"></i>
                            edit
                        </div>
                        <div
                            v-if="$page.user.id==post.user.id || $page.user.id==comment.user.id"
                            
                            class="p-2 hover:text-indigo-500 cursor-pointer"
                        >
                            <i class="fal fa-trash-alt pr-1" aria-hidden="true"></i>
                            delete
                        </div>
                        
                    </template>
                </jet-dropdown>
            </div>
        </div>
    </div>
</template>

<script>
import JetDropdown from "@/Jetstream/Dropdown";

export default {
    components:{
    JetDropdown,        
    },
    props: ["comments"],
};
</script>
