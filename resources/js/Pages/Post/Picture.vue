<template>
    <div class="p-1 pt-2">
        <img :src="'/'+src" class="rounded-sm h-96 object-contain w-full cursor-pointer" />
    </div>
</template>

<script>
export default {
    props:{
        src:String,
    }

}
</script>