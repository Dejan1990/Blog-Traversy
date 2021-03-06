<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only(['store', 'destroy']);
    }
    
    public function index()
    {
        $posts = Post::latest()->with(['user', 'likes'])->simplePaginate(20);

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
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

    public function destroy(Post $post)
    {
        /*if (!$post->ownedBy(auth()->user())) {
            return;
        }*/

        $this->authorize('delete', $post); // throw an exception
        $post->delete();

        return back();
    }
}
