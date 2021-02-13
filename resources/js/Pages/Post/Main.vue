<template>

    <div  class=" md:w-9/12 mt-4 mx-auto ">
        <div class=" bg-white rounded-xl p-2 shadow">
            
            <!-- Post owner -->
            <post-owner  
                :post="post" 
                :isowner="post.user.id == $page.user.id " 
                @delete-post="deletePost(post)" 
                @edit-post="editPost(post)" >
            </post-owner>
            <!-- Post owner -->
            
            <!-- Post text -->
            <post-text 
                v-if="post.text" 
                :text="post.text">
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
                :isReacted="isReacted(post,$page.user)"  
                :userid="$page.user.id" 
                :reacts="post.reacts" 
                :comments="post.comments">
            </react>
            <!-- post reactions -->

            <hr>
            <!--comments -->
            <div  class="comments overflow-auto pt-3 mt-2  px-2" >

                


                <div v-for="comment in post.comments" :key="comment.id" class="comments pb-2 flex">
                    <div class="pr-1">
                        <img class=" h-11 w-11 rounded-full object-cover  " 
                        :src="'/'+comment.user.picture">
                    </div>
                    <div class=" pl-1  w-11/12 ">
                        <p class=" capitalize font-semibold text-sm "> 
                        {{comment.user.firstname}} {{comment.user.firstname}}
                        </p>
                        <p class=" capitalize text-sm text-cool-gray-600  ">
                        {{comment.text}}
                        <span class="px-1 text-xl font-bold " >.</span>
                        <span class=" text-teal-400">{{ comment.created_at }}</span>
                        </p>
                    </div>
                </div>


                                    
            </div>
            <!-- comments -->

            <!--add comment -->
            <div class="px-2 pb-2">
                <input v-on:keyup.enter="addComment()" v-model="comment.text" type="text " class=" mt-2 text-gray-600 capitalize w-full focus:outline-none focus:ring focus:border-blue-300 rounded h-10 border-2 " />
            </div>
            <!--add comment -->
            
        </div>
    </div>
    
    </template>

    <script>
    // import post owner
import PostOwner from './Owner'
// import post text
import PostText from './Text'
// import post picture
import PostPicture from './Picture'

// import post reactions
import React from './React'

    export default {
        components:{
            React,
            PostOwner,
            PostText,
            PostPicture,
        },
        props:{
            post:{},
        },
        data() {
            return {
                comment:{text:null,post_id:null,},
            }
        },
        methods: {
            addComment(){
                if(this.comment.text!=null)
                {    
                    this.comment.post_id = this.post.id
                //    this.$emit('add-comment',[this.post,this.comment]);
                    axios.post('/comments',this.comment )
                            .then( Response => {
                                this.comment={text:null,post_id:null,}
                                console.table(Response.data);
                                this.post.comments.push(Response.data);
                            
                            })
                            .catch(err =>{console.log(err)})

                    
                }
            },
            deletePost(post){
                this.$emit('delete-post',post);
            },
            editPost(post){
                this.$emit('edit-post',post);
            
            },
            isReacted(post,user){

                return (post.reacts.filter(react => (react.user_id == user.id)).length > 0)
                ? true
                : false
                    //returns true or false
            },
            react(reaction,post){
                post.reacts.push(reaction);
            
            },

            unreact(reaction,post){
                post.reacts = post.reacts.filter( r => r.id!=reaction.id);
            },
        },

    }
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
        .comments{
            max-height: 12rem;
        }

    </style>