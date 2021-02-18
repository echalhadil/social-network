<template>
    <div :class="picturesClasses" >
        <div v-if="postHasPic.length > 0" class=" w-full mx-auto bg-white shadow rounded-lg p-2">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class=" shadow-lg rounded-md bg-gray-50 p-1 " v-for="post in postHasPic" :key="post.id">
                    <img class=" rounded-lg w-full h-60 object-contain " :src="'/'+post.picture" />
                </div>
            </div>
        </div>
        <div v-if="postHasPic.length == 0" class="text-center w-full mx-auto text-gray-600 shadow rounded-lg p-2">
            <p class=" mt-32 capitalize text-5xl " > no pictures</p>
            <i class="fa fa-broom fa-9x " aria-hidden="true"></i>
        </div>
    </div>
</template>

<script>
export default {
    props:['picturesClasses','posts'],
    computed: {
        postHasPic(){
            return this.posts.filter(p => p.picture!=null)
        }
    },
    
}
</script>