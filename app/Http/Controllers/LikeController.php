<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Models\Like;
use App\Models\Notification;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LikeController extends Controller
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
            //find the post
            $post = Post::find($request->id);

            // like it
            $like  = $post->likes()->create([
                'user_id' => Auth::id(),
            ]);

            // return the like back
            return response()->json($like);
        } catch (\Throwable $th) {
            return response()->json($th);
        } finally {
            $post = Post::find($request->id);
            if ((int) Auth::id() != (int) $post->user_id) {

                $notification = new Notification();
                $notification->maker_id = Auth::id();
                $notification->target_id = $post->user_id;
                $notification->type = 'r';
                $notification->post_id = $post->id;
                $notification->save();
                $notification->maker = $notification->maker;
                $notification->target = $notification->target;

                // event(new CommentEvent($notification));
                event(new NotificationEvent($notification));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        //find the like
        $like = Like::find($like->id);

        // delete the like .
        return response()->json($like->delete());
    }
}
