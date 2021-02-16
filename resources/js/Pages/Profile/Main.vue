<template>
    <app-layout>

        <div class="w-full bg-gray-100 pb-10" >

            <div class="w-11/12 bg-white mx-auto mt-6 shadow rounded-lg">
                <!-- cover -->
                <div class=" w-full h-64 ">
                    
                    <jet-dropdown align="right" width="44" class="float-right -mb-9 mr-2 mt-2 border hover:bg-gray-50 hover:text-indigo-500 cursor-pointer text-black rounded-full bg-white">
                        <template #trigger >
                            <div v-if="$page.profiler.id != $page.user.id">
                                <i class="fal fa-plus py-1 px-2" aria-hidden="true"></i>
                                <i class="fal fa-check py-1 px-2 text-indigo-500" aria-hidden="true"></i>
                                <i class="fal fa-minus py-1 px-2" aria-hidden="true"></i>
                                <i class="fal fa-times py-1 px-2" aria-hidden="true"></i>
                            </div>

                            <div v-if="$page.profiler.id == $page.user.id">
                                <i class="fal fa-pencil p-1" aria-hidden="true"></i>
                            </div>
                          
                        </template>

                        <template #content >
                            
                            <!--cover option -->
                            <div v-if="$page.profiler.id != $page.user.id" class="border border-grey-100 py-1 -my-1 capitalize text-gray-800 bg-white rounded ">
                                <div  class="hover:text-indigo-500 hover:bg-cool-gray-100 flex px-3 rounded-md py-1">
                                    <i class="fal fa-plus pr-2 my-auto" aria-hidden="true"></i>
                                    <p class=" "> add friend </p>
                                </div>
                                <div  class="hover:text-indigo-500 hover:bg-cool-gray-100 flex px-3 rounded-md py-1">
                                    <i class="fal fa-minus pr-2 my-auto" aria-hidden="true"></i>
                                    <p class=" "> unfriend </p>
                                </div>

                                <div class=" hover:text-indigo-500 hover:bg-cool-gray-100 flex px-3 rounded-md py-1">
                                    <i class="fal fa-times pr-2 my-auto" aria-hidden="true"></i>
                                    <p class=" "> Cancel request </p>
                                </div>

                                <div class=" hover:text-indigo-500 hover:bg-cool-gray-100 flex px-3 rounded-md py-1">
                                    <i class="fal fa-check pr-2 my-auto" aria-hidden="true"></i>
                                    <p class=" "> confirm </p>
                                </div>
                                <div class=" hover:text-indigo-500 hover:bg-cool-gray-100 flex px-3 rounded-md py-1">
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

                    <img class="w-full rounded-lg h-full object-cover   p-1 " src="https://i.pinimg.com/564x/d8/5f/45/d85f454c5884b1a0acbe576574f4b840.jpg"  />
                   
                </div>

                <div class=" w-full  ">
                    <div class=" w-36 h-36  mx-auto -mt-20 bg-transparent ">
                        <img class=" w-full h-full object-cover shadow-lg bg-transparent  rounded-full " 
                        :src="'/'+$page.profiler.picture" /> 
                        
                        <update-profile-picture 
                            v-if="$page.user.id == $page.profiler.id" 
                            :user="$page.profiler" 
                            @update-profile-picture="updateProfilePicture"
                            @delete-profile-picture ="deleteProfilePicture" 
                        />
                  

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

                    <i class="fal fa-2x" :class="{'fa-cogs':$page.profiler.id == $page.user.id,' fa-info-circle':$page.profiler.id != $page.user.id }" aria-hidden="true"></i>
                    <p v-if="$page.profiler.id == $page.user.id"> settings</p>    
                    <p v-if="$page.profiler.id != $page.user.id"> about</p>    

                </div>
            </div>

            
            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <timeline :timelineClasses="timelineClasses" />
           
            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <pictures :picturesClasses="picturesClasses" :posts="$page.profiler.posts" />

            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <friends :friendsClasses="friendsClasses" :posts="$page.profiler.posts" />

            <!-- ---------------------------------------------------------------------------------------------------------- -->

            <!-- ---------------------------------------------------------------------------------------------------------- -->
            
            <settings :settingsClasses="settingsClasses" />

            <!-- ---------------------------------------------------------------------------------------------------------- -->

        </div>
        
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    // import JetSectionBorder from '@/Jetstream/SectionBorder'
    // import LogoutOtherBrowserSessionsForm from './LogoutOtherBrowserSessionsForm'
    // import TwoFactorAuthenticationForm from './TwoFactorAuthenticationForm'
    import UpdateProfilePicture from './UpdateProfilePicture'
    // iport sweet alert
    import swal from 'sweetalert';
    import JetDropdown from '@/Jetstream/Dropdown'

    
    import Timeline from './Timeline'
    import Friends from './Friends'
    import Pictures from './Pictures'
    import Settings from './Settings'


    

    export default {
        // props: ['sessions'],

        components: {
            AppLayout,
            UpdateProfilePicture,
            JetDropdown,
            Timeline,
            Friends,
            Pictures,
            Settings,
          
            // JetSectionBorder,
            // LogoutOtherBrowserSessionsForm,
            // TwoFactorAuthenticationForm,
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
        },
        
        deleteProfilePicture(user,picture)
        {
            user.picture = picture;
        },
        

        
    },
   
    mounted() {
      
    },
    }
</script>

<style >

    
    .target:hover .dropdown-menu{
        display:block;
    }
   

</style>
