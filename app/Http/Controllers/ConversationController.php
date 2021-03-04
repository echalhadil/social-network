<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Inertia\Inertia as Inertia;

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
            $conversation->timeago = $conversation->getTimeAgo($conversation->updated_at);
            // $conversation->las_message = Crypt::decryptString($conversation->last_message);
            if ($conversation->from_id == Auth::id())
                $conversation->friend = User::find($conversation->to_id);
            else
                $conversation->friend = User::find($conversation->from_id);
        }

        return response()->json($c);
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
        if ($conversation) {
            $conversation->messages = $conversation->messages;

            if ($conversation->from_id == Auth::id())
                $conversation->friend = User::find($conversation->to_id);
            else
                $conversation->friend = User::find($conversation->from_id);

            return Inertia::render('Messenger/Main')->with("id", $id)->with("friend", $conversation->friend);
        } else

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

    public function messages($id)
    {

        $c = Conversation::find($id);

        foreach ($c->messages as $message) {
            $message->timeago = $message->created_at->shortRelativeDiffForHumans();
            // $message->text = Crypt::decryptString($message->text);
        }
        return response()->json($c->messages);
    }
}
