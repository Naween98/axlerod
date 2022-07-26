<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostType;
use App\Models\User;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Prophecy\Doubler\Generator\Node\ReturnTypeNode;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('id', 'DESC')->get();
        $vehicle_types = VehicleType::all();
        return view('posts', ["posts"=>$posts, "vehicle_types"=>$vehicle_types]);
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
        if ($request->post_type == 1) {
            $validated = $request->validate([
                "title" => ['required'],
                "vehicle_type_id" => ['required'],
                "problem" => ['required'],
                "garage" => ['required'],
                "feedback" => ['required'],
            ]);

            $post_type = PostType::where("type", '=', 'Feedback')->get();
        } elseif ($request->post_type == 2) {
            $validated = $request->validate([
                "title" => ['required'],
                "vehicle_type_id" => ['required'],
                "problem" => ['required'],
            ]);
            $post_type = PostType::where("type", '=', 'Need Help')->get();
        }
        
        $validated["post_type_id"] = $post_type[0]->id;
        $validated["views"] = 0;
        $user = User::find(auth()->user()->id);

        $post = $user->posts()->create($validated);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('post', ["post"=>$post]);
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
