<template>
    <div>
        <jet-dropdown align="right" width="44" class="float-right -mb-9 mr-2 mt-2 border hover:bg-gray-50 hover:text-indigo-500 cursor-pointer text-black rounded-full bg-white">
            <template #trigger >
                <div v-if="$page.profiler.id != $page.user.id">
                    <i 
                    v-if="!areFriends && !youSentRequest && !youRecivedRequest" 
                    class="fal fa-plus py-1 px-2" aria-hidden="true"></i>
                    <i v-if="areFriends" class="fal fa-check py-1 px-2 text-indigo-500" aria-hidden="true"></i>
                    <i v-if="youSentRequest" class="fal fa-minus py-1 px-2" aria-hidden="true"></i>
                    <i v-if="youRecivedRequest" class="fal fa-times py-1 px-2" aria-hidden="true"></i>
                </div>

                <div v-if="$page.profiler.id == $page.user.id">
                    <i class="fal fa-pencil p-1" aria-hidden="true"></i>
                </div>
            </template>

            <template #content >
                
                <!--cover option -->
                <div v-if="$page.profiler.id != $page.user.id" class="border border-grey-100 py-1 -my-1 capitalize text-gray-800 bg-white rounded ">
                    <div @click="sendFriendRequest($page.profiler.id)"  v-if="!areFriends && !youSentRequest && !youRecivedRequest"  class="hover:text-indigo-500 hover:bg-cool-gray-100 flex px-3 rounded-md py-1">
                        <i class="fal fa-plus pr-2 my-auto" aria-hidden="true"></i>
                        <p class=" "> add friend </p>
                    </div>
                    <div @click="unfriend($page.profiler.id)" v-if="areFriends" class="hover:text-indigo-500 hover:bg-cool-gray-100 flex px-3 rounded-md py-1">
                        <i class="fal fa-minus pr-2 my-auto" aria-hidden="true"></i>
                        <p class=" "> unfriend </p>
                    </div>

                    <div @click="deleteReq()" v-if="youSentRequest" class=" hover:text-indigo-500 hover:bg-cool-gray-100 flex px-3 rounded-md py-1">
                        <i class="fal fa-times pr-2 my-auto" aria-hidden="true"></i>
                        <p class=" "> Cancel request </p>
                    </div>

                    <div @click="confirmReq($page.user.id)" v-if="youRecivedRequest" class=" hover:text-indigo-500 hover:bg-cool-gray-100 flex px-3 rounded-md py-1">
                        <i class="fal fa-check pr-2 my-auto" aria-hidden="true"></i>
                        <p class=" "> confirm </p>
                    </div>
                    <div @click="deleteReq()" v-if="youRecivedRequest" class=" hover:text-indigo-500 hover:bg-cool-gray-100 flex px-3 rounded-md py-1">
                        <i class="fal fa-times pr-2 my-auto" aria-hidden="true"></i>
                        <p class=" "> delete</p>
                    </div>
                </div>
                <div v-if="$page.profiler.id == $page.user.id" class="border border-grey-100 py-1 -my-1 capitalize text-gray-800 bg-white rounded ">
                    <div class="hover:text-indigo-500 hover:bg-cool-gray-100 flex px-3 rounded-md py-1">
                        <i class="fal fa-pencil pr-2 my-auto" aria-hidden="true"></i>
                        <p class=" "> edit cover </p>
                    </div>

                    <div @click="removecover" class="hover:text-indigo-500 hover:bg-cool-gray-100 flex px-3 rounded-md py-1">
                        <i class="fal fa-trash pr-2 my-auto" aria-hidden="true"></i>
                        <p  class="">remove cover</p>
                    </div>
                </div>
                <!--cover option -->      
            </template>
        </jet-dropdown>
    </div>

</template>

<script>
    import JetDropdown from '@/Jetstream/Dropdown'
    import swal from 'sweetalert'

export default {
    components:{
        JetDropdown,
    },
    props:['profilerid'],
    
    data() {
        return {
            areFriends:false,
            youSentRequest:false,
            youRecivedRequest:false,

        }
    },
    methods: {
        sendFriendRequest(to_id){            
            axios.post('/friendrequests',{to_id,})
                .then(
                    response =>
                    {
                        console.log(response.data)
                        this.youSentRequest = true
                    }
                    )
                .catch(
                    err =>
                    {
                        console.log(err)
                    }
                )

        },

        unfriend(friend_id){
            swal({
                title: "Are you sure?",
                text: "Once you unfriend, you will not be able to see they posts!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    axios.delete('/friends/'+friend_id)
                        .then(
                            response =>
                            {
                                this.areFriends = false;
                                console.log(response.data)
                                console.log(areFriends);

                                swal("You Unfriend successfuly!", {
                                    icon: "success",
                                });
                            }
                            )
                        .catch(
                            err =>
                            {
                                console.log(err)
                            }
                        )

                    
                }
            });
            

        },

        confirmReq(user_id){
            axios.post('/friends/',{from_id:this.profilerid,to_id:user_id})
                .then(
                    response =>
                    {   console.log(response.data);
                        this.areFriends=true
                        this.youRecivedRequest = false
                        
                    }
                )
                .catch(
                    err =>
                    {
                        console.log(err)
                    }
                )
        },
        deleteReq(){
            
            axios.get(this.profilerid+'/deleterequest')
                    .then(
                        response =>
                        {   console.log(response.data);
                            this.youRecivedRequest = false;
                            this.youSentRequest = false;
                        }
                    )
                    .catch(
                        err =>
                        {
                            console.log(err)
                        }
                    )
        },

        status(){
            axios.get(this.profilerid+'/arefriends')
                .then(
                    res => 
                    {
                        this.areFriends = res.data
                        if(!this.areFriends)
                            axios.get(this.profilerid+'/yousentrequest')
                                .then(
                                    res => 
                                    {
                                        this.youSentRequest = res.data
                                        if(!this.youSentRequest)
                                            axios.get(this.profilerid+'/yourecivedrequest')
                                                .then(res => {this.youRecivedRequest = res.data})
                                                .catch(err =>{console.log(err)})
                                        })
                                .catch(err =>{console.log(err)})
                    })
                .catch(err =>{console.log(err)})

            

            
        }
        
    },
    mounted() {
        this.status();
    },
}
</script>