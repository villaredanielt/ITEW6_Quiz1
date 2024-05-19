<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Post;
class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return response()->json(['posts'=>$posts],200);
    }

    public function store(Request $request)
    {
        $post = Post::create($request->all());
        return response()->json(['post'=>$post], 201);
    }

    public function show($id)
    {
        $post =  Post::findOrFail($id);
        return response()->json(['post'=>$post],200);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return response()->json(['post'=>$post], 200);
    }

    public function destroy($id)
    {
        Post::findOrFail($id)->delete();
        return response()->json(null, 200);
    }
}
