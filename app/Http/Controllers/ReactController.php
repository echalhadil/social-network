<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\React;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactController extends Controller
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
        //find the post
        $post = Post::find($request->post_id);

        // search if exist
        $exist = React::where('user_id',Auth::id())
            ->where('post_id',$request->post_id)
            ->first();

        if($exist)
        {
            if($request -> type =="unlike")
                $this -> destroy($exist);
            else if($exist->type!= $request -> type )
            {
                $react = React::find($exist->id);
                $react -> type = $request -> type;
                $react -> save();
                return response() -> json('update');
            }
                
        }
        else{


        // react it
        $react  = $post ->reacts()->create([
            'user_id' => Auth::id(),
            'type' => $request -> type,
            ]);
        $react -> user = Auth::user();

        // return the like back
        return response() -> json($react);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\React  $react
     * @return \Illuminate\Http\Response
     */
    public function show(React $react)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\React  $react
     * @return \Illuminate\Http\Response
     */
    public function edit(React $react)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\React  $react
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, React $react)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\React  $react
     * @return \Illuminate\Http\Response
     */
    public function destroy(React $react)
    {
         //find the like
         $react = React::find($react->id);
         
         // delete the like .
        return response() -> json($react -> delete());
    }
}
