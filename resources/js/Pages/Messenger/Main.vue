<template>
    <app-layout>
        <div class=" flex mt-6 mx-3   ">
            <div class=" w-1/4 regular-height ">

                <div class=" p-2" >
                    <p class="capitalize text-lg font-semibold"> conversation</p>
                </div>

                <div class="px-2 py-1">
                    <input 
                    type="text" 
                    placeholder="Search Here" 
                    class="focus:outline-none focus:ring-2 focus:border-indigo-500 ml-auto bg-transparent h-10 capitalize w-full border-gray-300 border rounded-md "
                       
                    />
                </div>

                <conversations />
            </div>

            <div class=" w-2/4  h-40 bg-blue-500 ">
                <div class=" w-full px-2 py-3 bg-white flex shadow-lg">
                    <div class=" pr-1 "> 
                        <img src="https://i.pinimg.com/564x/cf/63/60/cf636099f5e41f4773c55c1a677c6326.jpg" 
                        class="h-14 w-14 rounded-full" 
                        />
                    </div>
                    <div class=" my-auto ">
                        <p class=" font-bold text-lg "> Echalh Adil </p>
                    </div>
                </div>
            </div>

            <div class="w-1/4  h-40 bg-green-500 ">
            </div>
            
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Conversations from './Conversations'

export default {
    components:{
        AppLayout,
        Conversations,
    }
}
</script>

<style >
    .regular-height{
        
         height: calc(100vh - 200px);

    }
    .conv::-webkit-scrollbar {
            width: 5px;
            }

    .conv::-webkit-scrollbar-track {
        background: #f1f1f1;
        }

    .conv::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        }

    .conv::-webkit-scrollbar-thumb:hover {
        background: #e5e8ef;
        }

    
</style>