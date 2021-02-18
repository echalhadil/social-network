<template >
    <div class="md:w-9/12 mt-4 mx-auto rounded-xl p-2 shadow bg-white">

        <div class=" capitalize text-2xl pl-3 mb-2 " >
        Add post
        </div>
        <div class=" border-t-2 border-gray-100">
           
            <div @click="openModal" class="p-3 cursor-pointer flex border-b-2 border-gray-100 " >
                
                <div class="pr-3">
                    <img 
                    class="rounded-full w-16 h-16 " 
                    :src="'http://127.0.0.1:8000/'+$page.user.picture" />
                </div>

                <div @click="openModal" class="my-auto cursor-pointer capitalize font-light text-gray-700">
                    write somthing here ...
                </div>
            </div>
       
            <div class="p-3 flex " >
                <div @click="openModal" class=" cursor-pointer flex bg-cool-gray-200 hover:bg-gray-300 p-2 rounded " >
                    <i class="my-auto fal fa-image"></i>
                    <p class=" capitalize my-auto ml-1" > Photo </p>
                </div>
            </div>
        </div>
        

        <!-- add post modal -->


        <div :class="modalClasses" >
            <div class=" absolute w-full h-full bg-gray-500 opacity-50"></div>
            
            <div class="bg-white md:w-1/2 p-2 w-5/6 mx-auto rounded-sm shadow-lg z-50 ">
            <!-- title -->
                <div class="p-1"> 
                    <p class=" text-3xl capitalize text-gray-800 " > Create post </p>
                </div>
                
            <!-- title -->
                <hr>
                <div class="p-3 flex " >
                
                    <div class="pr-3">
                        <img 
                        class="rounded-full w-16 h-16 " 
                        :src="'http://127.0.0.1:8000/'+$page.user.picture" />
                    </div>

                    <input type="text" v-model="post.text" class="my-auto border-red-600  w-5/6 h-14 capitalize font-light text-gray-700" placeholder="write somthing here ..." />
                        
                    
                </div>

                <hr class=" w-10/12 mx-auto border-gray-200 ">
                <div class="p-3 flex  " >
                   
                    <label for="input-image" roll="input" type="file" class=" cursor-pointer flex bg-cool-gray-200 hover:bg-gray-300 p-2 rounded " >
                        <i class="my-auto fal fa-image"></i>
                        <p class=" capitalize my-auto ml-1" > Photo </p>
                    </label>
                    <input id="input-image" accept="image/*" v-on:change="uploadfile" type="file" name="picture" class=" hidden "  />
                </div>

                <div class="pl-3 " v-if="preview_image!=''">
                    <i class=" rounded-full bg-cool-gray-300 hover:bg-cool-gray-200 -ml-2 -mt-2  px-1 py-0.5 float-right mb-1 absolute text-gray-800 fal fa-times cursor-pointer" v-on:click="preview_image ='' " type="button"></i>
                    <img class=" md:w-1/3 w-full h-60 object-cover rounded-sm"  :src="preview_image">
                </div>

                <hr>

                <div class=" flex mt-auto p-3 ml-auto w-4/12 ">
                    <button @click="closeModal" type="button" class=" mr-1 bg-gray-200 hover:bg-gray-100 border-gray-500 p-1 w-20  rounded-sm "> cancel </button>
                    <button @click="addPost" type="button" class=" bg-blue-600 hover:bg-blue-500 text-white  border-gray-500 p-1 w-20 rounded-sm" >post</button>
                </div>
            </div>
        </div>


        <!-- add post modal -->


        <!-- message -->
        <div 
            v-if="message.visible" 
            class="relative py-3 pl-4 pr-10 leading-normal rounded-lg  " 
            :class="{'text-green-700 bg-green-100':message.type,'text-red-700 bg-red-100':!message.type}" role="alert">
            <p class=" capitalize ">{{message.content}}</p>
            <span class="absolute inset-y-0 right-0 flex items-center mr-4">
                <svg @click="message.visible=false" class="w-4 h-4 fill-current" role="button" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
            </span>
        </div>
        <!--message -->

        
    </div>
</template>

<script>
export default {
     data() {
        return {
            modalClasses:'opacity-0 pointer-events-none fixed w-full h-screen top-0 left-0 flex items-center justify-center',
            post:{    
                text:'',
                picture:'',
            },
            preview_image:'',
            message:{
                type:true,
                content:'',
                visible:false,
            },
        }
    },
    methods: {
         openModal () {
            this.modalClasses="fixed w-full h-screen top-0 left-0 flex items-center justify-center";
        },
        closeModal(){
            this.modalClasses="opacity-0 pointer-events-none fixed w-full h-screen top-0 left-0 flex items-center justify-center";
            this.preview_image='';
            this.post={
                text:'',
                picture:'',
            };

        },
        uploadfile(){
            const reader = new FileReader();
    
            reader.readAsDataURL(document.getElementById('input-image').files[0]);
            
            this.post.picture = document.getElementById('input-image').files[0];
            
            reader.onload = () => { this.preview_image = reader.result }
        },

        addPost(){
               
                if(this.preview_image!=''|| this.post.text!=''){
                    var formData = new FormData();
                    formData.set('text', this.post.text);
                    formData.append('picture', this.post.picture);
                        
                    axios.post('/posts',formData,{headers: {'Content-Type': 'multipart/form-data',}} )
                        .then( Response => {
                            // this.posts.unshift(Response.data);
                           
                            this.closeModal();
                    
                            this.$emit('add-post',Response.data );
                            this.message={
                                type:true,
                                content:"your post has been published .",
                                visible:true,

                            }
                            setTimeout(() => {
                                this.message={
                                    type:true,
                                    content:"your post has been published .",
                                    visible:false,

                                }
                            }, 4000)
                        })
                        .catch(error => {
                            console.log(error)
                           
                            this.message={
                                type:false,
                                content:"something is wrrong .",
                                visible:true,
                            }
                            })
                    
            }
        }
    },
    
}
</script>