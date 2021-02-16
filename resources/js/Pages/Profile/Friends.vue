<template>
    <div :class="friendsClasses">
        <div v-if="friends.length>0" class=" w-full mx-auto bg-white shadow rounded-lg p-2">
            <div class="grid  grid-cols-1 md:grid-cols-3  gap-4">
                <div   v-for="friend in friends" :key="friend.id" class=" flex shadow rounded-lg p-1 bg-gray-50"  >
                    <div class=" md:w-28 w-24 h-24 md:h-28 " >
                        <img class=" rounded-lg w-full h-full object-cover " :src="'/'+friend.picture" />
                    </div>
                    <div class="pl-2 py-2 my-auto ">
                        <p class=" font-semibold " > {{friend.firstname}} {{friend.lastname}}</p> 
                        <p class=" text-gray-500 "> @{{ friend.username }}</p> 

                    </div>

                    <div v-if="friend.id != $page.user.id" class="target ml-auto my-auto bg-indigo-500 cursor-pointer hover:bg-indigo-400 rounded text-white p-2 ">
                        <p class=" font-semibold " > friends  </p> 
                        <!--friendship option -->
                        <div class=" border border-grey-100 mt-2 px-3 p-2 capitalize text-gray-800  dropdown-menu hidden absolute bg-white rounded ">
                            <div @click="unfriend(friend)" class="0 hover:text-indigo-500 flex py-2">
                                <i class="fal fa-user-minus pr-2"></i>
                                <p class=" "> unfriend </p>
                            </div>

                                <div class=" hover:text-indigo-500 flex py-2">
                                <i class="fal fa-user pr-2"></i>
                                <inertia-link  :href="'/profiles/'+friend.id" > view profile </inertia-link>
                            </div>
                        </div>
                        <!--friendship option -->


                    </div>
                    
                </div>
            </div>
        </div>
        <div v-if="friends.length==0" class=" text-gray-600 w-full mx-auto text-center  shadow rounded-lg p-2">
            <p class=" mt-32 capitalize text-5xl " > no friends.</p>
                <i class="fa fa-user-slash   fa-9x " aria-hidden="true"></i>
        </div>
    </div>
</template>

<script>
     import swal from 'sweetalert'
export default {
    component:{

    },
    props:['friendsClasses'],
    data() {
        return {
            friends:[],
        }
    },
    methods: {
        unfriend(friend){
            swal({
                title: "Are you sure?",
                text: "Once you unfriend, you will not be able to see they posts!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    this.friends = this.friends.filter(f => f.id != friend.id);
                    swal("You Unfriend successfuly!", {
                    icon: "success",
                    });
                }
            });
        },
        getFriends(){
            axios.get(window.location.href.split('/').pop()+'/friends')
                .then(response => 
                {
                    this.friends = _.uniqBy(response.data, 'id');
                    console.table(this.friends)
                })
                .catch(err => {console.log(err)})

        },
    },
    mounted() {
        this.getFriends();
    },
}
</script>
<style >

    
    .target:hover .dropdown-menu{
        display:block;
    }
   

</style>
