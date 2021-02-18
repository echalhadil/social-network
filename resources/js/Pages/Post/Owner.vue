<template>
    <div class=" w-full flex p-1 " >
        <!-- post owner picture -->
        <inertia-link :href="'http://127.0.0.1:8000/profiles/'+post.user.id" class=" pr-1">
            <img 
                class="w-13 h-13 object-cover rounded-full " 
                :src="'http://127.0.0.1:8000/'+post.user.picture" >
        </inertia-link>
        <!-- post owner picture -->

        <!-- post owner full name -->
        <div class="pl-2 my-auto w-7/12"> 
            <inertia-link :href="'http://127.0.0.1:8000/profiles/'+post.user.id" class="text-base font-bold capitalize">{{post.user.firstname}} {{post.user.lastname}}</inertia-link>
            <p class="text-teal-400 lowercase text-xs">{{ post.timeago}}</p>
        </div>
        <!-- post owner full name -->

        <!-- post options -->
        <div class="option ml-auto my-auto mr-1">
            <i class=" text-gray-400 cursor-pointer hover:text-gray-500 fa fa-ellipsis-h" aria-hidden="true"></i>
            <div class=" -ml-3 capitalize list-none dropdown-menu hidden shadow-lg absolute text-gray-800  rounded bg-white p-2">
                <li v-if="isowner" @click="editpost" class="p-2 hover:text-indigo-500 cursor-pointer" > 
                    <i class="fal fa-pencil pr-1" aria-hidden="true"></i> edit post
                </li>
                <li v-if="isowner" @click="deletepost" class="p-2 hover:text-indigo-500 cursor-pointer" > 
                    <i class="fal fa-trash-alt pr-1" aria-hidden="true"></i> delete post
                </li>
                <li v-if="!route().current('profiles.show') " class="p-2 hover:text-indigo-500 cursor-pointer" > 
                    <i class="fal fa-user pr-1" aria-hidden="true"></i> view profile
                </li>
            </div>
        </div>
        <!-- post options -->



    



        


    </div>
    
</template>

<script>
import Swal from 'sweetalert2';

export default {
    
    props:{
        // user,
        post:Object,
        isowner:Boolean,
        modalClasses:'opacity-0 pointer-events-none fixed w-full h-screen absolute top-0 left-0 flex items-center justify-center',
    },
    
    methods: {
        deletepost(){
            this.$emit('delete-post',this.post);
        },
        editpost(){
             this.$emit('edit-post', this.post);
           
        },


        
    },  
}
</script>

<style >
    

</style>