<template>
    <app-layout>

        <div class="w-full bg-gray-100 pb-10" >

            <div class="w-11/12 bg-white mx-auto mt-6 shadow rounded-lg">
                <!-- cover -->
                <div class=" w-full h-64 ">
                    <div v-if="$page.user.id == $page.profiler.id" class="target rounded-full border -mb-9 mr-2 mt-2 text-black float-right hover:bg-gray-50  hover:text-gray-800 cursor-pointer bg-white relative top-0 ">
                        <i class="fal fa-pencil p-1" aria-hidden="true"></i>
                        <!--cover option -->
                        <div class=" border border-grey-100 hidden  -ml-15 px-3 p-2 capitalize text-gray-800  dropdown-menu  absolute bg-white rounded ">
                            <div  class="0 hover:text-indigo-500 flex py-1">
                                <i class="fal fa-pencil pr-2" aria-hidden="true"></i>
                                <p class=" "> edit </p>
                            </div>

                                <div @click="removecover" class=" hover:text-indigo-500 flex py-1">
                                <i class="fal fa-trash pr-2" aria-hidden="true"></i>
                                <p  class="">remove </p>
                            </div>
                        </div>
                        <!--cover option -->
                        
                    
                    </div>
                    <img class="w-full rounded-lg h-full object-cover   p-1 " src="https://i.pinimg.com/564x/d8/5f/45/d85f454c5884b1a0acbe576574f4b840.jpg"  />
                   
                </div>

                <div class=" w-full  ">
                    <div class=" w-36 h-36  mx-auto -mt-20 bg-transparent ">
                        <img class=" w-full h-full object-cover shadow-lg bg-transparent  rounded-full " 
                        :src="'http://127.0.0.1:8000/'+$page.profiler.picture" /> 
                        
                        <update-profile-picture v-if="$page.user.id == $page.profiler.id" :user="$page.profiler" @update-profile-picture="updateProfilePicture" />
                  

                    </div>
                    <!-- full name -->
                    <div class=" text-center p-2 " >
                        <p class=" text-2xl capitalize font-bold " >
                            {{$page.profiler.firstname}} {{$page.profiler.lastname}} 
                        </p>
                    </div>
                </div>


            </div>

            <div class="w-11/12 mx-auto  bg-white mt-6 flex shadow rounded-lg  capitalize">
                <div 
                    @click="show('timeline')" 
                    :class="{
                        'bg-indigo-500 hover:bg-indigo-400 text-white':(currentsection == 'timeline'),
                        'hover:text-indigo-500 text-gray-700 ':(currentsection != 'timeline') ,
                        'w-1/4 text-center m-2 p-2 rounded cursor-pointer':true,
                    }">
                    <i class="fal fa-stream fa-2x"></i>
                    <p> timeline</p>
                </div>

                <div 
                @click="show('friends')" 
                :class="{
                        'bg-indigo-500 hover:bg-indigo-400 text-white':(currentsection == 'friends'),
                        'hover:text-indigo-500 text-gray-700 ':(currentsection != 'friends') ,
                        'w-1/4 text-center m-2 p-2 rounded cursor-pointer':true,
                    }">
                    <i class="fal fa-users fa-2x" aria-hidden="true"></i>
                    <p> friends</p>

                </div>

                <div 
                @click="show('pictures')" 
                :class="{
                        'bg-indigo-500 hover:bg-indigo-400 text-white':(currentsection == 'pictures'),
                        'hover:text-indigo-500 text-gray-700 ':(currentsection != 'pictures') ,
                        'w-1/4 text-center m-2 p-2 rounded cursor-pointer':true,
                    }" >
                    <i class="fal fa-images fa-2x  "></i>
                    <p> pictures</p>    
                </div>

                 <div 
                 @click="show('settings')" 
                :class="{
                        'bg-indigo-500 hover:bg-indigo-400 text-white':(currentsection == 'settings'),
                        'hover:text-indigo-500 text-gray-700 ':(currentsection != 'settings') ,
                        'w-1/4 text-center m-2 p-2 rounded cursor-pointer':true,
                    }" >
                    <i class="fal fa-cogs fa-2x" aria-hidden="true"></i>
                    <p> settings</p>    
                </div>
            </div>

            <!-- ---------------------------------------------------------------------------------------------------------- -->
            <div :class="timelineClasses">
                
                <div class="md:w-4/12 w-0 invisible md:visible ">
                    <div class="  w-9/12  ml-auto bg-white rounded-lg shadow ">

                        <div class=" text-center p-2 hover:bg-gray-50 hover:text-indigo-500 " >
                            <i class="fas fa-users    "></i>
                            <p>10 friends  </p>
                        </div>

                        <div class=" text-center p-2 hover:bg-gray-50 hover:text-indigo-500" >
                            <i class="fas  fa-stream  "></i>
                            <p>{{posts.length}} post<span class=" lowercase ">(s)</span>   </p>
                        </div>

                        <div class=" text-center p-2 hover:bg-gray-50 hover:text-indigo-500" >
                            <i class="fas  fa-images  "></i>
                            <p>{{countPictures}} picture<span class=" lowercase ">(s)</span>  </p>
                        </div>
                        

                    </div>
                </div>

                <div class=" md:w-8/12 w-full mx-auto mb-2 " >
                    <add-post  @add-post="addPost" style=" margin-top:0;" />

                    <div v-if="posts.length>0" v-for="post in posts" :key="post.id" class=" md:w-9/12 mt-4 mx-auto ">
                        <div class=" bg-white rounded-xl p-2 shadow">
                            
                            <!-- Post owner -->
                            <post-owner  :post="post" :isowner="post.user.id == $page.user.id " @delete-post="deletePost" @edit-post="editPost" ></post-owner>
                            <!-- Post owner -->
                        
                            <!-- Post text -->
                            <post-text v-if="post.text" :text="post.text">
                            </post-text>
                            <!-- Post text --> 

                            <!-- Post picture -->
                            <post-picture v-if="post.picture" :src="post.picture" ></post-picture>
                            
                            <!-- Post picture -->

                            <!-- post reactions -->
                            <react @unreact="unreact" @react="react" :post="post" :isReacted="isReacted(post,$page.user)"  :userid="$page.user.id" :reacts="post.reacts" :comments="post.comments"></react>
                            <!-- post reactions -->

                            <hr>
                            <!--comments -->
                            <div  class="comments overflow-auto pt-3 mt-2  px-2" >

                                


                                <div v-for="comment in post.comments" :key="comment.id" class=" pb-2 flex">
                                    <div class="pr-1">
                                        <img class=" h-11 w-11 rounded-full object-cover  " 
                                        :src="'http://127.0.0.1:8000/'+comment.user.picture">
                                    </div>
                                    <div class=" pl-1  w-11/12 ">
                                        <p class=" capitalize font-semibold text-sm "> 
                                        {{comment.user.firstname}} {{comment.user.firstname}}
                                        </p>
                                        <p class=" capitalize text-sm text-cool-gray-600  ">
                                        {{comment.text}}
                                        <span class="px-1 text-xl font-bold " >.</span>
                                        <span class=" text-teal-400">{{ comment.created_at }}</span>
                                        </p>
                                    </div>
                                </div>


                                                    
                            </div>
                            <!-- comments -->

                            <!--add comment -->
                            <div class="px-2 pb-2">
                                <input v-on:keyup.enter="addComment(post)" v-model="comment.text" type="text " class=" mt-2 text-gray-600 capitalize w-full focus:outline-none focus:ring focus:border-blue-300 rounded h-10 border-2 " />
                            </div>
                            <!--add comment -->
                            
                        </div>
                    </div>

                    <!-- if ther is no publications this will be visible -->
                    <div v-if="posts.length==0"  class="text-gray-600 mt-8 h-96  justify-items-center  md:w-9/12  mx-auto text-center">
                        <p class=" mt-32 capitalize text-5xl " > Aucune publication</p>
                        <i class="fa fa-moon-stars fa-9x " aria-hidden="true"></i>
                    </div>
                    <!-- if ther is no publications this will be visible -->

                
                </div>

            </div>
            <!-- ---------------------------------------------------------------------------------------------------------- -->


            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <div :class="picturesClasses" >
                <div class=" w-full mx-auto bg-white shadow rounded-lg p-2">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class=" shadow-lg rounded-md bg-gray-50 p-1 " v-for="post in posts" :key="post.id" v-if="post.picture!=null" >
                            <img class=" rounded-lg w-full h-60 object-contain " :src="'http://127.0.0.1:8000/'+post.picture" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- ---------------------------------------------------------------------------------------------------------- -->


            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <div :class="friendsClasses">
                <div class=" w-full mx-auto bg-white shadow rounded-lg p-2">
                    <div class="grid  grid-cols-1 md:grid-cols-3  gap-4">
                        <div class=" flex shadow rounded-lg p-1 bg-gray-50  " v-for="post in posts" :key="post.id" v-if="post.picture!=null" >
                            <div class=" md:w-28 w-24 h-24 md:h-28 " >
                                <img class=" rounded-lg w-full h-full object-cover " :src="'http://127.0.0.1:8000/'+post.picture" />
                            </div>
                            <div class="pl-2 py-2 my-auto ">
                                <p class=" font-semibold " > echalh adil  </p> 
                                <p class=" text-gray-500 ">  @echalhadil  </p> 

                            </div>

                            <div class="target ml-auto my-auto bg-indigo-500 cursor-pointer hover:bg-indigo-400 rounded text-white p-2 ">
                                <p class=" font-semibold " > friends  </p> 
                                <!--friendship option -->
                                <div class=" border border-grey-100 mt-2 px-3 p-2 capitalize text-gray-800  dropdown-menu hidden absolute bg-white rounded ">
                                    <div @click="unfriend" class="0 hover:text-indigo-500 flex py-2">
                                        <i class="fal fa-user-minus pr-2"></i>
                                        <p class=" "> unfriend </p>
                                    </div>

                                     <div class=" hover:text-indigo-500 flex py-2">
                                        <i class="fal fa-user pr-2"></i>
                                        <p class="">view profile </p>
                                    </div>
                                </div>
                                <!--friendship option -->


                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <!-- ---------------------------------------------------------------------------------------------------------- -->


 <!-- ---------------------------------------------------------------------------------------------------------- -->

            <div :class="settingsClasses" >
                <div class=" w-full mx-auto bg-white shadow rounded-lg p-2">
                    <update-profile-information-form :user="$page.user" />
                    <update-password-form class=" mt-6 " />
                    <delete-user-form />
                </div>
            </div>

            <!-- ---------------------------------------------------------------------------------------------------------- -->



        </div>
        
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DeleteUserForm from './DeleteUserForm'
    // import JetSectionBorder from '@/Jetstream/SectionBorder'
    // import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
    // import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
    import UpdatePasswordForm from './UpdatePasswordForm'
    import UpdateProfilePicture from './UpdateProfilePicture'
    import UpdateProfileInformationForm from './UpdateProfileInformationForm'
    import AddPost from '@/Pages/Post/AddPost'

    // import post owner
    import PostOwner from '@/Pages/Post/Owner'


    // import post text
    import PostText from '@/Pages/Post/Text'

    // import post picture
    import PostPicture from '@/Pages/Post/Picture'




    // import post reactions
    import React from '@/Pages/Post/React'

    // iport sweet alert
    import swal from 'sweetalert';

    export default {
        // props: ['sessions'],

        components: {
            AppLayout,
            AddPost,
            React,
            PostOwner,
            PostText,
            PostPicture,
            DeleteUserForm,
            UpdateProfilePicture,
            // JetSectionBorder,
            // LogoutOtherBrowserSessionsForm,
            // TwoFactorAuthenticationForm,
            UpdatePasswordForm,
            UpdateProfileInformationForm,
        },
        data() {
            return {
                posts:[],
                comment:{text:null,post_id:null,},
                timelineClasses:'w-11/12 mx-auto mt-6 flex rounded-lg capitalize',
                friendsClasses:'w-11/12 min-h-screen mx-auto hidden mt-6 rounded-lg capitalize',
                picturesClasses:'w-11/12 min-h-screen mx-auto hidden mt-6 rounded-lg capitalize',
                settingsClasses:'w-11/12 min-h-screen mx-auto hidden mt-6 rounded-lg capitalize',
                currentsection:'timeline',

            }
        },
        methods: {
        deletePost(post){
            console.log("deleted !");
            let id = post.id;

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this post",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Your post file has been deleted!", {
                    icon: "success",
                    button: "close",
                    });

                    this.posts = this.posts.filter(p => p.id =! post.id);

                    axios.delete('posts/'+id)
                    .then(response => {console.log(response.data)})
                    .catch(error => {console.log(error)});
                    
                } 
                
            });
        },
        editPost(post){
            console.log('edited');
            swal({
                text: "Edit post :",
                content: { 
                    element: "input",
                    attributes: {
                        placeholder: "Type your post text",
                        type: "text",
                        value:post.text,
                    },
                },
                buttons: true,
                }).then((value) => {
                // if (!value) throw null;
        
                post.text = document.querySelector(".swal-content__input").value;

                 axios.put('posts/'+post.id,post)
                .then( response =>{
                    console.log(response.data)
                } )
                .catch(error =>{
                    console.log(response.error)
                });
                post.text = text
                alert("you entered: " + text);
            });
            

        },

        addPost(post){
            console.log(post);

            this.posts.unshift(post);
            
        },

        getPosts(){
            axios.get('/posts')
            .then(response =>{
                this.posts = _.orderBy(response.data, ['id'], ['desc']);
            })
            .catch(error =>{
                console.log(error)
            })
        },
        addComment (post){
            if(this.comment.text!=null)
            {    
                try {
                    this.comment.post_id = post.id

                    axios.post('/comments',this.comment )
                    .then( Response => {
                        post.comments.push(Response.data);
                        this.comment = {text:null,post_id:null,};
                    })
                    .catch(error => {console.log(error)})
                    

                } catch (error) {
                    console.log(error);
                };

                
            }
        },

        isReacted(post,user){

            return (post.reacts.filter(react => (react.user_id == user.id)).length > 0)
            ? true
            : false
                //returns true or false
        },


        react(reaction,post){
            post.reacts.push(reaction);
         
        },

        unreact(reaction,post){
            post.reacts = post.reacts.filter( r => r.id!=reaction.id);
        }
        ,
        show(section)
        {
            this.currentsection = section;
            if(section =='timeline' )
            {
                
                this.timelineClasses = 'w-11/12 mx-auto mt-6 flex rounded-lg capitalize';
                this.friendsClasses = 'w-11/12  mx-auto hidden mt-6 rounded-lg capitalize';
                this.settingsClasses = this.picturesClasses = this.friendsClasses;
                
            }
            if(section =='pictures' )
            {
                this.timelineClasses = 'w-11/12 mx-auto hidden mt-6 rounded-lg capitalize';
                this.settingsClasses = this.friendsClasses = this.timelineClasses;
                this.picturesClasses = 'w-11/12 min-h-screen mx-auto flex mt-6 rounded-lg capitalize';
    
            }

            if(section =='friends' )
            {
                this.timelineClasses = 'w-11/12 mx-auto hidden mt-6 rounded-lg capitalize';
                this.friendsClasses = 'w-11/12 min-h-screen mx-auto flex mt-6 rounded-lg capitalize';
                this.picturesClasses =  this.settingsClasses = this.timelineClasses;
            }
            if(section =='settings' )
            {
                this.timelineClasses = 'w-11/12 mx-auto hidden mt-6 rounded-lg capitalize';
                this.friendsClasses = this.picturesClasses = this.timelineClasses;
                this.settingsClasses = 'w-11/12 min-h-screen mx-auto flex mt-6 rounded-lg capitalize';
            }
           

        },
        unfriend(){
            swal({
                title: "Are you sure?",
                text: "Once you unfriend, you will not be able to see they posts!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    swal("You Unfriend successfuly!", {
                    icon: "success",
                    });
                }
            });
        },
        removecover(){
            swal({
                title: "Are you sure?",
                text: "Once you unfriend, you will not be able to see they posts!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    swal("You Unfriend successfuly!", {
                    icon: "success",
                    });
                }
            });
        },
        
        removepicture(){
            swal({
                title: "Are you sure?",
                text: "Once you remove it, you will not be able to restore it!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    swal("Your Profile Picture Removed Successfuly!", {
                    icon: "success",
                    });
                }
            });
        },
        updateProfilePicture(user,picture)
        {
            user.picture = picture;
        }
        

        
    },
    computed: {
        countPictures(){
            let ps = this.posts;
            let n = ps.filter(p => p.picture!=null).length;
            return n;
        }
    },
    mounted() {
        this.getPosts();
    },
    }
</script>

<style >

    
    .target:hover .dropdown-menu{
        display:block;
    }
   

</style>
