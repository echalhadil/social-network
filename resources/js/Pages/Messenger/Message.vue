<template>
    <div class="p-2 flex">
        <!-- recive message -->
        <img v-if="$page.user.id != message.from_id" src="https://i.pinimg.com/564x/cf/63/60/cf636099f5e41f4773c55c1a677c6326.jpg"
        class="h-10 w-10 rounded-full" />
        <div v-if="$page.user.id != message.from_id" class="ml-2 w-3/4">
            <div class=" shadow p-2 bg-white rounded-t-lg rounded-r-lg  w-full ">
                <p class="text-gray-700 text-sm">
                {{message.text}}
                </p>
                
            </div>
            <div class="capitalize mt-1">
                <p class=" text-xs text-gray-500 ">sent {{message.timeago}} ago. </p>
            </div>
        </div>
        <div v-if="$page.user.id != message.from_id" class="my-auto ml-auto text-gray-600 mr-auto ">
            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
        </div>
        
    
        <!-- sent message -->
        <div v-if="$page.user.id == message.from_id" class="my-auto ml-auto text-gray-600">
            <i class=" ml-auto fa fa-ellipsis-h" aria-hidden="true"></i>
        </div>
        
        <div v-if="$page.user.id == message.from_id" class="ml-auto w-3/4 ">       

            <div class="ml-auto p-2 shadow bg-indigo-500 rounded-t-lg rounded-l-lg  w-full ">
                <p class="text-white text-sm">
                {{message.text}}
                </p>
                
            </div>
            <div class="w-3/4 ml-auto capitalize mt-1">
                <p class="float-right text-xs text-gray-500 ">sent {{message.timeago}} ago.</p>
            </div>
        </div>

        <img v-if="$page.user.id == message.from_id" src="https://i.pinimg.com/564x/cf/63/60/cf636099f5e41f4773c55c1a677c6326.jpg"
        class="h-10 w-10 rounded-full ml-2" />
        
    </div>
    

</template>

<script>
export default {
    props:['message'],

}
</script>

<style>
    .loading{
        background: linear-gradient(to right, #e5e7eb , #e3e3e3);
        animation: mymove 1s infinite;
    }
    @keyframes mymove {
    0% {background: linear-gradient(to right, #e5e7eb , #e3e3e3);}

    50% {background: linear-gradient(to right, #e3e3e3 , #e3e3e3);}


    100% {background: linear-gradient(to left, #e5e7eb , #e3e3e3);}
    }
</style>