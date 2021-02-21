<template>
        <app-layout>
            <div class="w-full bg-gray-100 flex" >
                <div class=" fixed h-screen bg-white w-1/4 pt-3 mr-auto shadow ">

                    <div class="ml-3 capitalize font-semibold my-2 ">
                        <p> filters</p>
                    </div>

                    <div class=" flex group hover:bg-cool-gray-200 cursor-pointer active:bg-cool-gray-200 mx-2 p-2 rounded">
                        <div class=" rounded-full group-hover:text-white group-hover:bg-indigo-500 w-8 h-8 text-center  ">
                            <i class="fal fa-podcast fa-x mt-2 " aria-hidden="true"></i>
                        </div>
                        <p class="pl-2 my-auto text-lg capitalize font-bold ">all</p>
                    </div>

                    <div class=" flex group hover:bg-cool-gray-200 cursor-pointer active:bg-cool-gray-200 mx-2 p-2 rounded">
                        <div class=" rounded-full group-hover:text-white group-hover:bg-indigo-500 w-8 h-8 text-center  ">
                            <i class="fal fa-users fa-x mt-2 " aria-hidden="true"></i>
                        </div>
                        <p class="pl-2 my-auto text-lg capitalize font-bold ">users</p>
                    </div>

                    <div class=" flex group hover:bg-cool-gray-200 cursor-pointer active:bg-cool-gray-200 mx-2 p-2 rounded">
                        <div class=" rounded-full group-hover:text-white group-hover:bg-indigo-500 w-8 h-8 text-center  ">
                            <i class="fal fa-calendar-day fa-x mt-2" aria-hidden="true"></i>
                        </div>
                        <p class="pl-2 my-auto text-lg capitalize font-bold ">posts</p>
                    </div>

            

                </div>

                <div class="w-2/3 ml-auto mt-3 pt-3 rounded-lg h-96 ">

                    <div v-for="user in $page.users" :key="user.id" class=" flex shadow rounded-lg p-1 bg-white w-2/3 mt-3  mx-auto" >
                        <inertia-link :href="'/profiles/'+user.id" class=" md:w-28 w-24 h-24 md:h-28 " >
                            <img class=" rounded-lg w-full h-full object-cover " :src="'/'+user.picture" />
                        </inertia-link>
                        <div class="pl-2 py-2 my-auto grid ">
                            <inertia-link :href="'/profiles/'+user.id" class=" font-semibold " > 
                                {{user.firstname}} {{user.lastname}}
                            </inertia-link> 
                            <inertia-link :href="'/profiles/'+user.id" class=" text-gray-500 "> 
                                @{{ user.username }}
                            </inertia-link> 

                        </div>

                        <div v-if="user.id != $page.user.id" class="target ml-auto my-auto bg-indigo-500 cursor-pointer hover:bg-indigo-400 rounded text-white p-2 ">
                            <div class=" font-semibold flex" > 
                                <i class="fal fa-check my-auto mr-1" aria-hidden="true"></i>
                                <p>friends</p> 
                            </div> 
                            <!--friendship option -->
                            <div class=" border border-grey-100 mt-2 px-3 p-2 capitalize text-gray-800  dropdown-menu hidden absolute bg-white rounded ">
                                <div @click="unfriend(user)" class="0 hover:text-indigo-500 flex py-2">
                                    <i class="fal fa-user-minus pr-2"></i>
                                    <p class=" "> unfriend </p>
                                </div>

                                <inertia-link  :href="'/profiles/'+user.id" class=" hover:text-indigo-500 flex py-2">
                                    <i class="fal fa-user pr-2"></i>
                                    <p> view profile </p>
                                </inertia-link>
                            </div>
                            <!--friendship option -->


                        </div>
                        
                    </div>

                    <div v-for="post in $page.posts" :key="post.id" class=" shadow rounded-lg p-1 w-2/3 mt-3  mx-auto bg-white ">
                        <!-- owner -->
                        <div class="flex m-2">
                            <div class="">
                                <img class=" h-15 w-15 rounded-full "  src="https://i.pinimg.com/564x/a0/f0/02/a0f002f1f149ec32516de35e920fe946.jpg" />
                            </div>
                            <div class="ml-2 capitalize text-black my-auto">
                                <p class="font-semibold ">{{post.user.firstname}} {{post.user.lastname}}</p>
                                <p class=" text-sm ">@{{post.user.username}}</p>
                            </div>

                            <div class=" ml-auto my-auto  cursor-pointer ">
                                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                            </div>
                        </div>
                        <!-- content -->
                        <div class=" mt-3 flex ">
                            <div class="flex ml-2 text-sm w-5/6 ">
                                <p class="pr-2 text-green-600"> {{post.timeago}}. </p>
                                <p class=" ">
                                {{post.text}}
                                </p>
                            </div>
                           <img class="  ml-auto rounded h-28 w-28  m-2 object-cover "  :src="'/'+post.picture" />
                            
                        </div>
                    </div>

                    <div  class=" p-1 w-2/3 mt-4  text-center mx-auto" >
                        <p class=" w-2/3 font-semibold capitalize mx-auto border-b-2 text-lg "> end of results </p>
                    </div>


                </div>
            </div>

        </app-layout>
</template>

<script>
        import AppLayout from '@/Layouts/AppLayout'
export default {
    components:{
        AppLayout,
    }
}
</script>

<style >

    
    .target:hover .dropdown-menu{
        display:block;
    }
   

</style>