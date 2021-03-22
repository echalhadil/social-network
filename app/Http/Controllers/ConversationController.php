<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        
        $c = Conversation::where('from_id', Auth::id())
            ->orWhere('to_id',  Auth::id())
            ->get();
        foreach ($c as $conversation) {
            $conversation->timeago = $conversation->getTimeAgo($conversation->updated_at);
            
            $conversation->friend =  ($conversation->from_id == Auth::id()) ?
                User::find($conversation->to_id):
                User::find($conversation->from_id);
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
        $request->validate([
            "text" => "required",
            "to_id"=> "required",
        ]);

        $c = Conversation::where('from_id', Auth::id())->Where('to_id',  $request->to_id)->first();
        if ($c != null) {
            $c->last_message = $request->text;
            $c->save();
            $c->friend = User::find($request->to_id);
            $c->timeago = $c->getTimeAgo($c->updated_at);


            $message = new Message();
            $message->conversation_id = $c->id;
            $message->text = $request->text;
            $message->from_id = Auth::id();
            $message->save();

            event(new MessageEvent($message, $c));

            return response()->json($c);
        } else
        if (null != Conversation::where('to_id', Auth::id())->Where('from_id',  $request->to_id)->first()) {
            $c =  Conversation::where('to_id', Auth::id())->Where('from_id',  $request->to_id)->first();

            $c->last_message = $request->text;
            $c->save();
            $c->friend = User::find($request->to_id);
            $c->timeago = $c->getTimeAgo($c->updated_at);


            $message = new Message();
            $message->conversation_id = $c->id;
            $message->text = $request->text;
            $message->from_id = Auth::id();
            $message->save();

            event(new MessageEvent($message, $c));

            return response()->json($c);
        } else
            try {


                $conversation = new Conversation();
                $conversation->from_id = Auth::id();
                $conversation->to_id = $request->to_id;
                $conversation->last_message = $request->text;
                $conversation->save();
                $conversation->timeago = $conversation->getTimeAgo($conversation->updated_at);



                $conversation->friend = User::find($request->to_id);

                $message = new Message();
                $message->conversation_id = $conversation->id;
                $message->text = $request->text;
                $message->from_id = Auth::id();
                $message->save();

                return response()->json($conversation);
            } catch (\Throwable $th) {
                throw $th;
            } finally {
                event(new MessageEvent($message, $conversation));
            }
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

        $conversation = Conversation::with('messages')->find($id);

        if ($conversation && $this->partOfConversation($conversation)) {

            $conversation->friend = ($conversation->from_id == Auth::id()) ? 
             User::find($conversation->to_id) : 
             User::find($conversation->from_id);

            return Inertia::render('Messenger/Main')->with("id", $id)->with("friend", $conversation->friend);
        } else

            // return response()->json("error conversation not found");
            abort(404);
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
    public function destroy(Conversation $conversation)
    {
        $conversation->messages()->forceDelete();
        $conversation->delete();
        return response()->json("ok");
    }

    public function messages($id)
    {

        $conversation = Conversation::with('messages')->find($id);
        if ($conversation && $this->partOfConversation($conversation)) {

            foreach ($conversation->messages as $message) {
                $message->timeago = $message->created_at->shortRelativeDiffForHumans();
            }
            return response()->json($conversation->messages);
        }
        abort(404);
    }


























    public function partOfConversation(Conversation $conversation)
    {
        return ($conversation->from_id == Auth::id() || $conversation->to_id == Auth::id()) ? true : false;
    }
}
