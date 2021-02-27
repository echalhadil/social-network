<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $c = Conversation::all();
        foreach ($c as $conversation) {
            $conversation->timeago = $conversation->getTimeAgo($conversation->created_at);
            if($conversation->from_id == Auth::id())
                $conversation->friend = User::find($conversation->to_id);
            else
                $conversation->friend = User::find($conversation->from_id);
            
        }

        return response() -> json($c);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $conversation = Conversation::find($id);
        if($conversation){
            $conversation->messages = $conversation->messages;

            if($conversation->from_id == Auth::id())
                $conversation->friend = User::find($conversation->to_id);
            else
                $conversation->friend = User::find($conversation->from_id);
            
            return response()->json($conversation);

        }
        else

        return response()->json("error conversation not found");
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
