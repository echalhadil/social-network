<template>
        <div>
            
            <div  class=" rounded-full target -mt-8 mr-6 border  text-black float-right hover:bg-gray-100  hover:text-gray-800 cursor-pointer bg-white relative top-0 ">
                <i class="fal fa-pencil p-1" aria-hidden="true"></i>
                
                <!--profile picture option -->
                <div class=" border border-grey-100 hidden px-3 p-2 capitalize text-gray-800  dropdown-menu  absolute bg-white rounded ">
                    <div @click="confirmingUserDeletion = true"  class="hover:text-indigo-500 flex py-1">
                        <i class="fal fa-pencil pr-2" aria-hidden="true"></i>
                        <p class=" "> edit </p>
                    </div>

                    <div  @click="" class=" hover:text-indigo-500 flex py-1">
                        <i class="fal fa-trash pr-2" aria-hidden="true"></i>
                        <p  class="">remove </p>
                    </div>
                </div>
                <!--profile picture option -->

            </div>


            <!-- Delete Account Confirmation Modal -->
            <jet-dialog-modal :show="confirmingUserDeletion" @close="confirmingUserDeletion = false">
                <template #title>
                    Update Profile Picture
                </template>

                <template #content>
                    
                    <div class="mt-4">
                        <label for="input-profile-picture" roll="input" type="file" class=" cursor-pointer flex bg-cool-gray-200 hover:bg-gray-300 p-2 rounded " >
                            <i class="my-auto fal fa-image"></i>
                            <p class=" capitalize my-auto ml-1" > Photo </p>
                        </label>
                        <input id="input-profile-picture" accept="image/*" v-on:change="uploadfile" type="file" name="picture" class=" hidden "  />
                    </div>

                    <div v-if="preview_image!=''" class="pl-3 " >
                        <i class=" rounded-full bg-cool-gray-300 hover:bg-cool-gray-200 -ml-2 -mt-2  px-1 py-0.5 float-right mb-1 absolute text-gray-800 fal fa-times cursor-pointer" v-on:click="preview_image ='' " type="button"></i>
                        <img class=" md:w-1/3 w-full h-60 object-cover rounded-sm"  :src="preview_image">
                    </div>
                </template>

                <template #footer>
                    <jet-secondary-button @click.native="confirmingUserDeletion = false">
                        Cancel
                    </jet-secondary-button>

                    <button 
                        @click="updateProfilePicture"
                        class="ml-2 px-4 py-2 ring shadow border rounded-md bg-indigo-500 text-white  hover:text-indigo-500 hover:bg-gray-50"
                        :class="{ 'opacity-50': (preview_image=='') }" :disabled="preview_image==''"
                    >
                        Update
                    </button>
                </template>
            </jet-dialog-modal>
        </div>
</template>

<script>
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        components: {
            JetActionSection,
            JetDangerButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
        },
        props:['user'],

        data() {
            return {
                confirmingUserDeletion: false,
                picture:'',
                preview_image:'',
            }
        },
        methods: {
            confirmUserDeletion() {         
                this.confirmingUserDeletion = true;
            },
            uploadfile(){

                const reader = new FileReader();
        
                reader.readAsDataURL(document.getElementById('input-profile-picture').files[0]);
                
                this.picture = document.getElementById('input-profile-picture').files[0];
                
                reader.onload = () => { this.preview_image = reader.result };
                
            },
            updateProfilePicture() {
                // this.form.post(route('current-user.destroy'), {
                //     preserveScroll: true
                // }).then(response => {
                //     if (! this.form.hasErrors()) {
                //         this.confirmingUserDeletion = false;
                //     }
                // })
                var formData = new FormData();
                formData.set('user_id',this.user.id);
                formData.append('picture', this.picture);
                        
                axios.post(this.user.id+'/updateprofilepicture',formData,{headers: {'Content-Type': 'multipart/form-data',}})
                .then(response =>{
                
                    this.$emit('update-profile-picture',this.user,this.preview_image);
                    this.confirmingUserDeletion = false;

                })
                .catch( error => {
                    console.log(error);
                })

            },
        },
    }
</script>


<style >

    
    .target:hover .dropdown-menu{
        display:block;
    }
   

</style>
