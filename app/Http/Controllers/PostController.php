<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(request $request)
    {
      $data = $request->validate([
            'content' => 'required',
        ]);
        $post = Post::create([
            'content' => $data['content'],
            'user_id' => $request->user_id
        ]);

        return response()->json(["post"=>$post], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id = null)
    {
        $post =$id ? Post::with('user')->findOrFail($id): Post::with('user')->get();

        return response()->json(["posts"=>$post], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
