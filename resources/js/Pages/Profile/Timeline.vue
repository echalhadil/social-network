<template>
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
            <add-post 
                v-if="$page.user.id == $page.profiler.id"  
                @add-post="addPost" 
                class="mb-4 -mt-0.5" 
            />

            <post 
                v-if="posts.length > 0" 
                v-for="post in posts" 
                :key="post.id"  
                :post="post"
                @delete-post="deletePost"
                @edit-post="editPost"
            />

            <!-- if ther is no publications this will be visible -->
            <div v-if="posts.length==0"  class="text-gray-600 mt-8 h-96 justify-items-center md:w-9/12 mx-auto text-center">
                <p class=" mt-32 capitalize text-5xl " > Aucune publication</p>
                <i class="fa fa-moon-stars fa-9x " aria-hidden="true"></i>
            </div>
            <!-- if ther is no publications this will be visible -->

        
        </div>

    </div>
</template>

<script>
    import AddPost from '@/Pages/Post/AddPost'
    import swal from 'sweetalert'
    import Post from '@/Pages/Post/Main'

export default {
    props:['timelineClasses'],
    
    components: {
            AddPost,  
            Post,   
    },
    data() {
        return {
            posts:[],
            comment:{text:null,post_id:null},
        }
    },
    methods: {
        addPost(post){
            console.log(post);

            this.posts.unshift(post);
            
        },
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
                    console.table(post.id);
                    this.posts = this.posts.filter(p => p.id =! post.id);

                    axios.delete('/posts/'+id)
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
                if(post.text!==document.querySelector(".swal-content__input").value)
               {post.text = document.querySelector(".swal-content__input").value;

                        axios.put('/posts/'+post.id,post)
                        .then( response =>{
                            console.log(response.data)
                        } )
                        .catch(error =>{
                            console.log(response.error)
                        });
               }
            });
            

        },
        addComment(){
            if(this.comment.text!=null)
            {    
                this.comment.post_id = this.post.id
            //    this.$emit('add-comment',[this.post,this.comment]);
                axios.post('/comments',this.comment )
                    .then( Response => {
                        this.comment={text:null,post_id:null,}
                        console.table(Response.data);
                        this.post.comments.push(Response.data);  
                    })
                    .catch(err =>{console.log(err)})
                
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
        },
        getPosts(){
            axios.get(window.location.href.split('/').pop()+'/posts')
            .then(response =>{
                // console.table(response.data)
                this.posts = _.orderBy(response.data, ['id'], ['desc']);
            })
            .catch(error =>{
                console.log(error)
            })
        },
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
