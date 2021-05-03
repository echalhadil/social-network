<template>
    <app-layout>
        <div class=" w-full bg-gray-100  flex pb-10 overflow-x-hidden ">
            <div class=" md:w-8/12 mt-4 mb-2 mx-auto ">
                <add-post @add-post="addPost"> </add-post>

                <div
                    v-if="!loading && posts.length > 0"
                    v-for="post in posts"
                    :key="post.id"
                    class=" md:w-9/12 mt-4 mx-auto "
                >
                    <div class=" bg-white rounded-xl p-2 shadow">
                        <!-- Post owner -->
                        <post-owner
                            :post="post"
                            :isowner="post.user.id == $page.user.id"
                            @delete-post="deletePost"
                            @edit-post="editPost"
                        ></post-owner>
                        <!-- Post owner -->

                        <!-- Post text -->
                        <post-text v-if="post.text" :text="post.text">
                        </post-text>
                        <!-- Post text -->

                        <!-- Post picture -->
                        <post-picture
                            v-if="post.picture"
                            :src="post.picture"
                        ></post-picture>

                        <!-- Post picture -->

                        <!-- post reactions -->
                        <react
                            @unreact="unreact"
                            @react="react"
                            :post="post"
                            :isReacted="isReacted(post, $page.user)"
                            :userid="$page.user.id"
                            :reacts="post.reacts"
                            :comments="post.comments"
                        ></react>
                        <!-- post reactions -->

                        <hr />
                        
                        <post-comments 
                        :comments="post.comments"
                        :isowner="post.user.id == $page.user.id"
                        @delete-comment="deleteComment"
                         />

                        <!--add comment -->
                        <div class="px-2 pb-2">
                            <input
                                v-on:keyup.enter="addComment(post)"
                                v-model="comment.text"
                                type="text "
                                class=" mt-2 text-gray-600 capitalize w-full focus:outline-none focus:ring focus:border-blue-300 rounded h-10 border-2 "
                            />
                        </div>
                        <!--add comment -->
                    </div>
                </div>

                <!-- if ther is no publications this will be visible -->
                <div
                    v-if="!loading && posts.length == 0"
                    class="text-gray-600 mt-8 h-96  justify-items-center  md:w-9/12  mx-auto text-center"
                >
                    <p class=" mt-32 capitalize text-5xl ">
                        Aucune publication
                    </p>
                    <i class="fa fa-moon-stars fa-9x " aria-hidden="true"></i>
                </div>
                <!-- if ther is no publications this will be visible -->

                <!-- if loading -->
                <loading v-if="loading" />
                <loading v-if="loading" />
                

                
            </div>

            <div class="md:w-4/12 right-0 invisible md:visible mt-8 w-0">
                <div
                    class=" mr-auto w-10/12 p-3 capitalize  shadow rounded-lg bg-white "
                >
                    <div class=" pb-3">
                        <img
                            class=" h-28 w-28 rounded-full mx-auto object-cover"
                            :src="'/' + $page.user.picture"
                        />
                    </div>
                    <div class=" w-full justify-items-center ">
                        <p class=" text-center mx-auto font-bold text-3xl ">
                            {{ $page.user.firstname }} {{ $page.user.lastname }}
                        </p>

                        <p
                            class=" text-center mx-auto mb-2 text-gray-500 text-sm "
                        >
                            @{{ $page.user.username }}
                        </p>
                    </div>
                    <hr class=" w-10/12 mx-auto " />
                    <div class=" flex pt-3  ">
                        <inertia-link
                            :href="'/profiles/' + $page.user.id"
                            class="p-2 w-1/2 text-center hover:bg-gray-100 rounded hover:text-indigo-500 cursor-pointer"
                        >
                            <i class="fal fa-user pr-1 " aria-hidden="true"></i>
                            profile
                        </inertia-link>
                        <div
                            class="p-2 text-center  w-1/2 hover:bg-gray-100 rounded  hover:text-indigo-500 cursor-pointer"
                        >
                            <i class="fal fa-cog pr-1" aria-hidden="true"></i>
                            settings
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>

import JetDropdown from "@/Jetstream/Dropdown";

import AppLayout from "@/Layouts/AppLayout";
import AddPost from "./Post/AddPost";

// import post owner
import PostOwner from "./Post/Owner";

// import post text
import PostText from "./Post/Text";

// import post picture
import PostPicture from "./Post/Picture";

// import post reactions
import React from "./Post/React";

import Loading from "./Post/Loading";

import PostComments from "./Post/Comment";

// iport sweet alert
import swal from "sweetalert";
export default {
    components: {
        JetDropdown,
        AppLayout,
        AddPost,
        React,
        PostOwner,
        PostText,
        PostPicture,
        Loading,
        PostComments,
    },
    data() {
        return {
            posts: [],
            comment: { text: null, post_id: null },
            loading: true
        };
    },
    methods: {
        // function to delete posts
        deletePost(post) {
            console.log("deleted !");
            let id = post.id;

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this post",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then(willDelete => {
                if (willDelete) {
                    swal("Your post file has been deleted!", {
                        icon: "success",
                        button: "close"
                    });

                    this.posts = this.posts.filter(p => (p.id = !post.id));

                    axios
                        .delete("posts/" + id)
                        .then(response => {
                            console.log(response.data);
                        })
                        .catch(error => {
                            console.log(error);
                        });
                }
            });
        },

        // function to edit the posts 
        editPost(post) {
            console.log("edited");
            swal({
                text: "Edit post :",
                content: {
                    element: "input",
                    attributes: {
                        placeholder: "Type your post text",
                        type: "text",
                        value: post.text
                    }
                },
                buttons: true
            }).then(value => {
                // if (!value) throw null;

                post.text = document.querySelector(
                    ".swal-content__input"
                ).value;

                axios
                    .put("posts/" + post.id, post)
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.log(response.error);
                    });
                post.text = text;
                alert("you entered: " + text);
            });
        },

        // function to add posts 
        addPost(post) {
            console.log(post);

            this.posts.unshift(post);
        },

        // function to get posts 
        getPosts() {
            axios
                .get("/posts")
                .then(response => {
                    this.posts = _.orderBy(response.data, ["id"], ["desc"]);
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        // function to add comment
        addComment(post) {
            if (this.comment.text != null) {
                try {
                    this.comment.post_id = post.id;

                    axios
                        .post("/comments", this.comment)
                        .then(Response => {
                            post.comments.push(Response.data);
                            this.comment = { text: null, post_id: null };
                        })
                        .catch(error => {
                            console.log(error);
                        });
                } catch (error) {
                    console.log(error);
                }
            }
        },


        editComment(){},

        deleteComment(comment){
            var thepost =_.find( this.posts, o => { return o.id ==  comment.post_id; });
            thepost.comments =thepost.comments.filter(c =>c.id !=comment.id);
            thepost.comments.without(comment)
        },

        isReacted(post, user) {
            return post.reacts.filter(react => react.user_id == user.id)
                .length > 0
                ? true
                : false;
            //returns true or false
        },

        react(reaction, post) {
            post.reacts.push(reaction);
        },

        unreact(reaction, post) {
            post.reacts = post.reacts.filter(r => r.id != reaction.id);
        }
    },
    mounted() {
        this.getPosts();
    }
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
