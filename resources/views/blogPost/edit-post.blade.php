@extends('layouts.layout')
@section('head')
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
@endsection

@section('main')
    <main class="container" style="background-color: #fff">
        <section id="contact-us">
            <h1 style="padding-top: 50px">Edit Post</h1>
            @if (Session('status'))
                <span class="notify">{{ Session('status') }}</span>
            @endif
            <div class="contact-form">
                <form action="{{ route('post.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" value="{{ $post->title }}">
                        @error('title')
                            <span class="error-bag">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="Image">Image</label>
                        <input type="file" name="image" id="image">
                        @error('image')
                            <span class="error-bag">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea name="body" id="body">{{ $post->body }}</textarea>
                        @error('body')
                            <span class="error-bag">{{ $message }}</span>
                        @enderror
                    </div>

                    <input type="submit" value="submit">
                </form>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        CKEDITOR.replace('body');
    </script>
@endsection
