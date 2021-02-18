<template>
    <!-- comments -->
    <div class=" comments pl-4 cursor-pointer ">
        <div class="flex">
            <i class="fa fa-comment my-auto pr-1" aria-hidden="true"></i>
            <p class="my-auto hover:text-cool-gray-500 ">{{comments.length}} comments</p>
        </div>
        <div v-if="comments.length>0" class="list-none dropdown-menu hidden absolute bg-gray-800 w-40 rounded text-white p-2">
            
            <li v-for="comment in whoCommented" :key="comment.id" class="hover:text-gray-300" > 
                {{ comment.user.firstname }} {{ comment.user.lastname }}  
            </li>

        </div>
    </div>
    <!-- comments -->
</template>

<script>
export default {
    props:['comments'],
}
</script>