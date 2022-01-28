<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->with(['user', 'likes'])->simplePaginate(20);

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $request->user()->posts()->create($request->only('body'));
       /* $request->user()->posts()->create($request->validate([
            'body' => 'required'
        ])); */
       /* Post::create([
           'user_id' => auth()->id(), // bilo bi neophodno dodati 'user_id' u $fillable u Post.php
           'body' => $request->body
       ]); */

        return back();
    }
}
