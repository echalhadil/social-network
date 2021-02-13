<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::find(Auth::id());
        $friends = array();
        $friendships1 = $user -> friendsFromMe;
        $friendships2 = $user -> friendsToMe;

        foreach ($friendships1 as $friendship) {
            if($friendship ->from_id == $user->id)
                $friends[] = User::find($friendship->to_id);
            else
                $friends[] = User::find($friendship->from_id);
        }

        foreach ($friendships2 as $friendship) {
            if($friendship ->from_id == $user->id)
                $friends[] = User::find($friendship->to_id);
            else
                $friends[] = User::find($friendship->from_id);
        }

        return response() ->json($friends);
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
        
        $request -> from_id;
        $request -> to_id;
        $exist = Friend::where('from_id',$request->from_id)
            ->where('to_id',$request->to_id)
            ->get();
        if(!$exist)
        {
            $exist = Friend::where('to_id',$request->from_id)
            ->where('from_id',$request->to_id)
            ->get();
            if(!$exist)
            {   $user = User::find(Auth::id());
                $user ->  friendsFromMe() -> create([
                    'to_id' => $request->to_id,
                ]);
                return response() ->json(true);
        
            }

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function show(Friend $friend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function edit(Friend $friend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Friend $friend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Friend  $friend
     * @return \Illuminate\Http\Response
     */
    public function destroy(Friend $friend)
    {
        //
        $post = Friend::find($friend->id);
        $post -> delete();
        
        return response() ->json(true);
    }
}
