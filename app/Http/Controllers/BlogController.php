<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    function index()
    {
        return view('blog');
    }
    function show()
    {
        return view('blog-post');
    }
}
