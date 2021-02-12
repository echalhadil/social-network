<template>
     <div :class="timelineClasses">
                
        <div class="md:w-4/12 w-0 invisible md:visible ">
            <div class="  w-9/12  ml-auto bg-white rounded-lg shadow ">

                <div class=" text-center p-2 hover:bg-gray-50 hover:text-indigo-500 " >
                    <i class="fas fa-users    "></i>
                    <p>10 friends  </p>
                </div>

                <div class=" text-center p-2 hover:bg-gray-50 hover:text-indigo-500" >
                    <i class="fas  fa-stream  "></i>
                    <p>{{posts.length}} post<span class=" lowercase ">(s)</span>   </p>
                </div>

                <div class=" text-center p-2 hover:bg-gray-50 hover:text-indigo-500" >
                    <i class="fas  fa-images  "></i>
                    <p>{{countPictures}} picture<span class=" lowercase ">(s)</span>  </p>
                </div>
                

            </div>
        </div>

        <div class=" md:w-8/12 w-full mx-auto mb-2 " >
            <add-post v-if="$page.user.id == $page.profiler.id"  @add-post="addPost" class="mb-4 -mt-0.5" />

            <div v-if="posts.length>0" v-for="post in posts" :key="post.id" class=" md:w-9/12 mb-4 mx-auto ">
                <div class=" bg-white rounded-xl p-2 shadow">
                    
                    <!-- Post owner -->
                    <post-owner  :post="post" :isowner="post.user.id == $page.user.id " @delete-post="deletePost" @edit-post="editPost" ></post-owner>
                    <!-- Post owner -->
                
                    <!-- Post text -->
                    <post-text v-if="post.text" :text="post.text">
                    </post-text>
                    <!-- Post text --> 

                    <!-- Post picture -->
                    <post-picture v-if="post.picture" :src="post.picture" ></post-picture>
                    
                    <!-- Post picture -->

                    <!-- post reactions -->
                    <react @unreact="unreact" @react="react" :post="post" :isReacted="isReacted(post,$page.user)"  :userid="$page.user.id" :reacts="post.reacts" :comments="post.comments"></react>
                    <!-- post reactions -->

                    <hr>
                    <!--comments -->
                    <div  class="comments overflow-auto pt-3 mt-2  px-2" >

                        


                        <div v-for="comment in post.comments" :key="comment.id" class=" pb-2 flex">
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
                        <input v-on:keyup.enter="addComment(post)" v-model="comment.text" type="text " class=" mt-2 text-gray-600 capitalize w-full focus:outline-none focus:ring focus:border-blue-300 rounded h-10 border-2 " />
                    </div>
                    <!--add comment -->
                    
                </div>
            </div>

            <!-- if ther is no publications this will be visible -->
            <div v-if="posts.length==0"  class="text-gray-600 mt-8 h-96  justify-items-center  md:w-9/12  mx-auto text-center">
                <p class=" mt-32 capitalize text-5xl " > Aucune publication</p>
                <i class="fa fa-moon-stars fa-9x " aria-hidden="true"></i>
            </div>
            <!-- if ther is no publications this will be visible -->

        
        </div>

    </div>
</template>

<script>
    import AddPost from '@/Pages/Post/AddPost'
    // import post owner
    import PostOwner from '@/Pages/Post/Owner'
    // import post text
    import PostText from '@/Pages/Post/Text'
    // import post picture
    import PostPicture from '@/Pages/Post/Picture'
    // import post reactions
    import React from '@/Pages/Post/React'
    // iport sweet alert
    import swal from 'sweetalert'

export default {
    props:['timelineClasses','posts'],
    
    components: {
            AddPost,
            React,
            PostOwner,
            PostText,
            PostPicture,      
    },
    data() {
        return {
            
        }
    }
}
</script>