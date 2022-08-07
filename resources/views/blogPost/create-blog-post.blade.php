@extends('layouts.layout')
@section('head')
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
@endsection

@section('main')
    <main class="container" style="background-color: #fff">
        <section id="contact-us">
            <h1 style="padding-top: 50px">Create New Post</h1>

            @include('includes.flash-message');

            <div class="contact-form">
                <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}">
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
                        <label for="category">Category:</label><br>
                        <select name="category_id" id="categories">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="error-bag">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea name="body" id="body">{{ old('body') }}</textarea>
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
