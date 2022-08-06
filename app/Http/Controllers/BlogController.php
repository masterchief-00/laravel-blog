<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }


    function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->with('status', 'Post deleted!');
    }
    function update(Request $request, Post $post)
    {

        if (auth()->user()->id != $post->user()->id) {
            abort(403);
        }


        $request->validate([
            'title' => 'required',
            'image' => 'required|image',
            'body' => 'required'
        ]);
        $postId = $post->id;
        $title = $request->input('title');
        $slug = Str::slug($title, '-') . '-' . $postId;
        $body = $request->input('body');

        //file upload
        $imagePath = 'storage/' . $request->file('image')->store('postImages', 'public');

        $post->title = $title;
        $post->slug = $slug;
        $post->body = $body;
        $post->imagePath = $imagePath;
        $post->update();

        return redirect()->back()->with('status', 'Post updated!');
    }
    function edit(Post $post)
    {
        if (auth()->user()->id != $post->user()->id) {
            abort(403);
        }
        return view('blogPost.edit-post', compact('post'));
    }
    function store(Request $request)
    {
        $post = new Post();

        $request->validate([
            'title' => 'required',
            'image' => 'required|image',
            'body' => 'required'
        ]);
        $postId = Post::latest()->take(1)->first()->id;
        $title = $request->input('title');
        $slug = Str::slug($title, '-') . '-' . $postId + 1;
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

        return redirect()->back()->with('status', 'Post created!');
    }
    function create()
    {
        return view('blogPost.create-blog-post');
    }
    function index(Request $request)
    {
        if ($request->search) {
            $searchQuery = '%' . $request->search . '%';
            $posts = Post::where('title', 'like', $searchQuery)
                ->orWhere('body', 'like', $searchQuery)->latest()->paginate(4);
        }
        else
        {
            $posts = Post::latest()->paginate(4);
        }        
        return view('blogPost.blog', compact('posts'));
    }
    function show($slug)
    {
        $post = Post::where('slug', $slug)->first();
        return view('blogPost.blog-post', compact('post'));
    }
}
