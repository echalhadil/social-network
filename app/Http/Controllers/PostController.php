<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Post as GlobalPost;
use Illuminate\Http\UploadedFile;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $posts = Post::all();

        foreach ($posts as $post) {
            $post-> user = $post -> user;

           $post->comments = $post -> comments;

           foreach ($post->comments as $comment) {
               $comment -> user = $comment -> user;
           }

           $post->reacts = $post -> reacts;
           foreach ($post->reacts as $react) {
            $react -> user = $react -> user;
        }

        }

        return response() -> json($posts);
       
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //rules 
        if($request->text=='')
        $request->validate([
            'picture' =>'file|image',
        ]);
       
        if($request ->hasFile('picture'))
        $picture = $request->file('picture')->store('images/posts');
        else
        $picture=$request->picture;

        
        $user = User::find(Auth::id());

         $post = $user -> posts() -> create([
            'text' => $request ->text,
            'picture' => $picture,
        ]);

        $post -> user = $user;
        $post -> reacts = array();
        $post -> comments = array();



        return response() -> json( $post );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        $post -> user = $post -> user ;
        $post -> reacts = $post -> reacts ;
        $comments = $post -> comments = $post -> comments ;

        foreach ($comments as $comment) {
            $comment ->user = $comment ->user ;
        }

        return response() -> json($post);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        $post  = Post::find($post->id);
        $post -> text  = $request->text ;
        $post -> save();
    

        return response() -> json(true);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $post = Post::find($post->id);
        $post -> comments() -> delete();
        $post -> reacts() -> delete();
        $post -> delete();

        return response() -> json("ok");
    }
}
