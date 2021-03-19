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

                <jet-dropdown align="right" width="32" class="ml-auto" v-if="isowner || $page.user.id==comment.user.id">
                    <template class="" #trigger>
                        <i
                            class="text-gray-400 cursor-pointer hover:text-gray-500 fa fa-ellipsis-h"
                            aria-hidden="true"
                        ></i>
                    </template>

                    <template #content>
                        <div
                            v-if="$page.user.id==comment.user.id"
                            @click="editComment(comment)"
                            class="p-2 flex  hover:text-indigo-500 cursor-pointer"
                        >
                            <i class="fal fa-pencil pr-1" aria-hidden="true"></i>
                            edit
                        </div>
                        <div
                            v-if="isowner || $page.user.id==comment.user.id"
                            @click="deleteComment(comment)"
                            
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

import swal from "sweetalert";

export default {
    components:{
        JetDropdown,        
    },
    props: ["comments","isowner"],
    methods: {
        deleteComment(comment){
 
            swal({
                title: "Are you sure?",
                //text: "Once deleted, you will not be able to recover this comment",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then(willDelete => {
                if (willDelete) {
                    swal("Deleted!", {
                        icon: "success",
                        button: "close"
                    });
 
                    axios
                        .delete("comments/" + comment.id)
                        .then(response => {
                            console.log(response.data);
                            this.$emit('delete-comment', comment);
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
            });

        },
        editComment(comment){
            console.log("edited");
            swal({
                text: "Edit comment :",
                content: {
                    element: "input",
                    attributes: {
                        placeholder: "Type your comment",
                        type: "text",
                        value: comment.text
                    }
                },
                buttons: true
            }).then(value => {
                // if (!value) throw null;

                comment.text = document.querySelector(
                    ".swal-content__input"
                ).value;

                axios
                    .put("comments/" + comment.id, comment)
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.log(response.error);
                    });
                
            });
        },
    },
};
</script>

<style>
.comments::-webkit-scrollbar {
    width: 3px;
}

.comments::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.comments::-webkit-scrollbar-thumb {
    background: #e5e7eb;
}

.comments::-webkit-scrollbar-thumb:hover {
    background: #555;
}
.comments {
    max-height: 12rem;
}



</style>
