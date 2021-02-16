<?php

namespace App\Http\Controllers;

use App\Events\CommentEvent;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia as Inertia;

class ProfileController extends Controller 
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
       
        $user = User::find($id);

        if($user)
        {
            $user -> posts = $user -> posts;
        foreach ($user -> posts as $post) {
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
           
            
            return Inertia::render('Profile/Main')->with('profiler',$user);
            
        }

        else
        return Inertia::render('Main');

            


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit( $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy( $profile)
    {
        //
    }

    public function updateProfilePicture($id,Request $request)
    {
        $request->validate([
            'picture' =>'file|image',
        ]);
       
        if($request ->hasFile('picture'))
        {
        $picture = $request->file('picture')->store('images/users');
        $user = User::find($id);
        $user -> picture = $picture ; 
        $user -> save();

        return response() -> json($user -> picture);
        }
        else return response() -> json(false);
    }


    


    public function deleteProfilePicture($id)
    {
        $user = User::find($id);
        $user -> picture = 'images/users/male_user.jpg';
        $user -> save();

        return response() -> json($user -> picture);
    }

    public function posts($id){
        $user= User::find($id);
        $user -> posts = $user -> posts;
        foreach ($user -> posts as $post) {
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

        return response() ->json($user->posts);
    }


    public function friends($id){
        $user= User::find($id);
        $friends = array();
        $friends1= $user -> friendsFromMe;
        $friends2= $user -> friendstoMe;
        foreach ($friends1 as $friend) {
            $friends[] = User::find($friend -> to_id);
        }
        foreach ($friends2 as $friend) {
            $friends[] = User::find($friend -> from_id);
        }

        return response() ->json($friends);
    }
}
