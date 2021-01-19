<template>
    <div class=" w-11/12 mx-auto mt-2 " >
        <input v-on:keyup.enter="addComment" v-model="newComment" type="text" class="w-full h-9 focus:placeholder-white  text-gray-600 bg-gray-50 form-input border-blue-700 hover:border-blue-300 "  placeholder="add comment ..."  />
    </div>
</template>

<script>
export default {

    data() {
        return {
            newComment:'',
        }
    },
    
    methods: {
        addComment(){

            if(this.newComment!="")
            {
                alert(this.newComment);

                this.newComment=''

            }
            
        }
    },
}
</script>