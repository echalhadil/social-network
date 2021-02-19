<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Post ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
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
        try {   
            //create post's comment
            $post = Post::find($request -> post_id);
            $comment = $post 
                        -> comments() 
                        -> create([
                            'text'      => $request -> text,
                            'user_id'   => Auth::id(),
                        ]);
            $comment ->timeago = $post->getTimeAgo($comment->created_at);

            //get post user 
            $comment -> user = $comment -> user;

            return response() -> json($comment);

        } catch (\Throwable $th) { 
            return response() -> json($th);
        }
        finally{
            $p = Post::find($request -> post_id);
            if((int) Auth::id()!= (int) $p->user_id){

            $notification = new Notification();
            $notification->maker_id = Auth::id();
            $notification->target_id = $p->user_id;
            $notification->type = 'c';
            $notification->post_id = $request->post_id;
            $notification->save();
            $notification->maker = $notification->maker;
            $notification->target = $notification->target;

            // event(new CommentEvent($notification));
            event( new NotificationEvent($notification) );
            
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
        $comment -> delete();

        return response() -> json("ok");
    }
}
