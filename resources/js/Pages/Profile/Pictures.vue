<template>
    <div :class="picturesClasses" >
        <div class=" w-full mx-auto bg-white shadow rounded-lg p-2">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class=" shadow-lg rounded-md bg-gray-50 p-1 " v-for="post in posts" :key="post.id" v-if="post.picture!=null" >
                    <img class=" rounded-lg w-full h-60 object-contain " :src="'/'+post.picture" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['picturesClasses','posts']
    
}
</script>