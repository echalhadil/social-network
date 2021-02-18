<template>
        <app-layout>
            <div class="w-full bg-gray-100 flex" >
                <div class=" h-screen bg-white w-1/3 mr-auto shadow ">
                </div>
                <div class="w-2/3 mx-auto mt-3 pt-3 rounded-lg h-96">

                    <div v-for="user in $page.results" :key="user.id" class=" flex shadow rounded-lg p-1 bg-white w-2/3 mt-3  mx-auto" >
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