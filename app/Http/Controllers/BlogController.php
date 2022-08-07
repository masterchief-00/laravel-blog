<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
            'body' => 'required',
            'category_id' => 'required'
        ]);

        if (Post::all()->count() > 0) {
            $postId = Post::latest()->take(1)->first()->id;
        } else {
            $postId = 1;
        }


        $title = $request->input('title');
        $slug = Str::slug($title, '-') . '-' . $postId + 1;
        $user_id = Auth::user()->id;
        $category_id = $request->input('category_id');
        $body = $request->input('body');

        //file upload
        $imagePath = 'storage/' . $request->file('image')->store('postImages', 'public');

        $post->title = $title;
        $post->slug = $slug;
        $post->user_id = $user_id;
        $post->category_id = $category_id;
        $post->body = $body;
        $post->imagePath = $imagePath;
        $post->save();

        return redirect()->back()->with('status', 'Post created!');
    }
    function create()
    {
        $categories = Category::all();
        return view('blogPost.create-blog-post', compact('categories'));
    }
    function index(Request $request)
    {
        $categories = Category::all();
        if ($request->search) {
            $searchQuery = '%' . $request->search . '%';
            $posts = Post::where('title', 'like', $searchQuery)
                ->orWhere('body', 'like', $searchQuery)->latest()->paginate(4);
        } elseif ($request->category) {
            $posts = Category::where('name', $request->category)->firstOrFail()->posts()->paginate(4)->withQueryString();
        } else {
            $posts = Post::latest()->paginate(4);
        }
        return view('blogPost.blog', compact('posts', 'categories'));
    }
    function show(Post $post)
    {
        $category = $post->category;

        $relatedPosts = $category->posts()->where('id', '!=', $post->id)->latest()->take(3)->get();
        return view('blogPost.blog-post', compact('post', 'relatedPosts'));
    }
}
