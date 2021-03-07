<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FriendRequest;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        $user = User::find($id);

        return $user ?  Inertia::render('Profile/Main')->with('profiler', $user) : abort(404);
    }

    public function youSentRequest($id)
    {
        return response()->json(FriendRequest::where('to_id', $id)->where('from_id', Auth::id())->first() ? true : false);
    }

    public function youRecivedRequest($id)
    {
        return response()->json(FriendRequest::where('from_id', $id)->where('to_id', Auth::id())->first() ? true : false);
    }

    public function areFriends($id)
    {
        foreach ($this->friends($id) as $friend) {
            if ((int)$friend->id = (int) Auth::id())
                return response()->json(true);
        }

        return response()->json(false);
    }

    public function deleteRequest($from_id)
    {
        $fr = FriendRequest::where('from_id', Auth::id())->where('to_id', $from_id)->first();
        if ($fr)
            $fr->delete();
        $fr = FriendRequest::where('to_id', Auth::id())->where('from_id', $from_id)->first();
        if ($fr)
            $fr->delete();

        return response()->json(true);


        // $fr = FriendRequest::where('from_id', Auth::id())->where('to_id', $from_id)->first() || FriendRequest::where('to_id', Auth::id())->where('from_id', $from_id)->first();
        // $fr->delete();
        // return response()->json(true);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit($profile)
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
    public function destroy($profile)
    {
        //
    }

    public function updateProfilePicture($id, Request $request)
    {
        $request->validate([
            'picture' => 'file|image',
        ]);

        if ($request->hasFile('picture')) {
            $picture = $request->file('picture')->store('images/users');
            $user = User::find($id);
            $user->picture = $picture;
            $user->save();

            return response()->json($user->picture);
        } else
            return response()->json(false);
    }


    public function deleteProfilePicture($id)
    {
        $user = User::find($id);
        $user->picture = 'images/users/male_user.jpg';
        $user->save();

        return response()->json($user->picture);
    }



    public function posts($id)
    {
        $user = User::find($id);
        $user->posts = $user->posts;
        foreach ($user->posts as $post) {
            $post->user = $post->user;
            $post->timeago = $post->getTimeAgo($post->created_at);

            $post->comments = $post->comments;


            foreach ($post->comments as $comment) {
                $comment->user = $comment->user;
                $comment->timeago = $post->getTimeAgo($comment->created_at);
            }

            $post->reacts = $post->reacts;
            foreach ($post->reacts as $react) {
                $react->user = $react->user;
            }
        }

        return response()->json($user->posts);
    }


    public function friends($id)
    {
        $user = User::find($id);
        $friends = array();
        $friends1 = $user->friendsFromMe;
        $friends2 = $user->friendstoMe;
        foreach ($friends1 as $friend) {
            $friends[] = User::find($friend->to_id);
        }
        foreach ($friends2 as $friend) {
            $friends[] = User::find($friend->from_id);
        }

        return $friends;
    }
}
