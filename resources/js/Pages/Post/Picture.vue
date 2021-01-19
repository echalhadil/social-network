<template>
    <div class="p-1 pt-2">
        <img :src="'http://127.0.0.1:8000/'+src" class="rounded-sm h-96 object-contain w-full cursor-pointer" />
    </div>
</template>

<script>
export default {
    props:{
        src:String,
    }

}
</script>