<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
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
}
