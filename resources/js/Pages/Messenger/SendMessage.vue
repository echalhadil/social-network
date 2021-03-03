<template>
    <div class="p-2  bg-white ">
        <input
            type="text"
            placeholder="type a message text"
            class="focus:outline-none focus:ring-2 focus:border-indigo-500 ml-auto bg-white h-10 w-full border-gray-300 border rounded-sm "
            v-model="text"
            v-on:keyup.enter="sendMessage($page.id)"
        />
    </div>
</template>
<script>
export default {
    data() {
        return {
            text:'',
        }
    },

    methods: {
        sendMessage(conversation_id){
            if(this.text!='')
            this.$emit('send-message', this.text,conversation_id);
            this.text = '';

        }
    },
}
</script>