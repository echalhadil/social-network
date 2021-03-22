<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class MessageController extends Controller
{
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

        $request->text;
        $request->conversation_id;

        $request->validate([
            "text" => "required",
            "conversation_id" => "required",
        ]);

        $conversation = Conversation::find($request->conversation_id);
        $conversation->last_message =  $request->text;
        $conversation->save();
        $conversation->timeago = $conversation->getTimeAgo($conversation->updated_at);
        $conversation->from_id == Auth::id()?
                $conversation->friend = User::find($conversation->to_id)
            :
                $conversation->friend = User::find($conversation->from_id);
                

        $message = $conversation->messages()->create([
            'text'=>$request->text,
            'from_id'=>Auth::id()
        ]);
        $message->timeago = $message->created_at->shortRelativeDiffForHumans();
        event(new MessageEvent($message,$conversation));
        


        return response()->json($message);
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
