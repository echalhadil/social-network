<template>

    <div
        class="cursor-pointer hover:text-indigo-700 mx-auto "
        >
        <jet-dropdown align="right" width="72">
            <template #trigger>
                <i v-on:click="newConversations=0"
                    class="far fa-envelope"
                    aria-hidden="true"
                >
                <b
                        v-if="newConversations != 0"
                        class=" fixed w-3 p-0.5 -ml-1 -mt-2 text-center text-white text-xs bg-red-600 rounded-full "
                        >

                        {{
                            newConversations > 9
                                ? "9+"
                                : newConversations
                        }}
                    </b>
                </i>
            </template>

            <template #content>
                <div
                    class="block px-4 py-2 text-sm text-gray-400"
                >
                    Conversations
                    <inertia-link href="/messenger" class=" float-right text-xs text-indigo-500 font-semibold capitalize "> messenger </inertia-link>
                </div>

                <div
                    class="border-t border-gray-100"
                ></div>
                <div
                    v-if="conversations.length == 0"
                    class="px-4 text-gray-400 text-center "
                >
                    <i
                        class="fa mt-7 fa-3x fa-comment-alt-slash"
                        aria-hidden="true"
                    ></i>
                    <p class=" mb-7 mt-3 text-sm  ">
                        No Conversations
                    </p>
                </div>

                <div
                    v-if="conversations.length > 0"
                    class=" text-gray-400 text-sm h-64 "
                >
                    <inertia-link
                        v-for="conversation in conversations"
                        :key="conversation.id"
                        class=" p-2 flex hover:bg-gray-100 "
                        :href="'/conversations/'+conversation.id"
                    >
                        <div>
                            <img
                                class=" h-12 w-12 rounded-full mr-1 my-auto "
                                :src="
                                    '/' +
                                        conversation
                                            .friend
                                            .picture
                                "
                            />
                        </div>
                        <div class="my-auto">
                            <p class=" font-bold text-gray-800 ">{{conversation.friend.firstname}} {{conversation.friend.lastname}} </p>
                            <p class="text-xs truncate float-left  text-gray-500">
                                {{
                                    conversation.last_message
                                }} .
                                <span class=" float-right ml-1 text-gray-400 text-xs ">
                                {{
                                    conversation.timeago
                                }}
                                </span>
                            </p>
                            
                        </div>
                        <div v-if="true" class="ml-auto my-auto">
                        
                            <i class="fa circle fa-circle text-indigo-500 fa-xs    "></i>
                        </div>
                    </inertia-link>
                </div>
            </template>
        </jet-dropdown>
    </div>

</template>

<script>
import JetDropdown from "@/Jetstream/Dropdown";
export default {
    components:{
        JetDropdown,
    },
    data() {
        return {
            
            conversations: [],
            newConversations:0,
         
        }
    },  
    methods: {

        getConversations() {
            axios
                .get("/conversations")
                .then(res => {
                    this.conversations = _.orderBy(
                        res.data,
                        ["updated_at"],
                        ["desc"]
                    );
                })
                .catch(err => {
                    console.log(err);
                });
        }
        
    },
    mounted() {
        this.getConversations();

             
          Echo.channel("message-channel-" + this.$page.user.id).listen(
            ".MessageEvent",
            data => {
                let conversation = data.conversation;

              
                var match = _.find(this.conversations, ["id", conversation.id]);
                if (match) {
                    var index = _.indexOf(
                        this.conversations,
                        _.find(this.conversations, ["id", conversation.id])
                    );
                    this.conversations.splice(index, 1, conversation);
                    this.conversations = _.orderBy(
                        this.conversations,
                        ["updated_at"],
                        ["desc"]
                    );
                } else {
                    this.conversations.unshift(conversation);
                }
                this.newConversations++;

                this.playSound();

                //    else
                //    this.conversations.unshift(conversation);
            }
        );
    },
}
</script>