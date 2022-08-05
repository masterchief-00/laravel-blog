<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    function store(Request $request)
    {
        $post = new Post();

        $request->validate([
            'title' => 'required',
            'image' => 'required|image',
            'body' => 'required'
        ]);

        $title = $request->input('title');
        $slug = Str::slug($title, '-');
        $user_id = Auth::user()->id;
        $body = $request->input('body');

        //file upload
        $imagePath = 'storage/' . $request->file('image')->store('postImages', 'public');

        $post->title = $title;
        $post->slug = $slug;
        $post->user_id = $user_id;
        $post->body = $body;
        $post->imagePath = $imagePath;
        $post->save();

        return redirect()->back();
    }
    function create()
    {
        return view('blogPost.create-blog-post');
    }
    function index()
    {
        return view('blogPost.blog');
    }
    function show()
    {
        return view('blogPost.blog-post');
    }
}
