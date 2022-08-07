@extends('layouts.layout')

@section('main')
    <!-- main -->
    <main class="container">
        <h2 class="header-title">All Blog Posts</h2>
        @if (Session('status'))
            <span class="notify">{{ Session('status') }}</span>
        @endif
        <div class="searchbar">
            <form action="">
                <input type="text" placeholder="Search..." name="search" />

                <button type="submit">
                    <i class="fa fa-search"></i>
                </button>

            </form>
        </div>
        <div class="categories">
            <ul>
                <li><a href="">Health</a></li>
                <li><a href="">Entertainment</a></li>
                <li><a href="">Sports</a></li>
                <li><a href="">Nature</a></li>
            </ul>
        </div>
        <section class="cards-blog latest-blog">

            @forelse ($posts as $post)
                <div class="card-blog-content">
                    @auth
                        @if (auth()->user()->id == $post->user->id)
                            <div class="post-buttons">
                                <a href="{{ route('post.edit', $post) }}">Edit</a>
                                <form action="{{ route('post.destroy',$post) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" value="Delete">
                                </form>
                            </div>
                        @endif
                    @endauth
                    <img src="{{ asset($post->imagePath) }}" alt="" />
                    <p>
                        {{ $post->created_at->diffForHumans() }}
                        <span>{{ $post->user->name }}</span>
                    </p>
                    <h4>
                        <a href="{{ route('post.show', $post) }}">{{ $post->title }}</a>
                    </h4>
                </div>
                @empty
                <p>Sorry, the post you're looking does not exists.</p>
            @endforelse
        </section>

        <!-- pagination -->
        {{$posts->links('pagination::default')}}        
        <br>
    </main>
@endsection
