@extends('layouts.layout')
@section('head')
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>
@endsection

@section('main')
    <main class="container" style="background-color: #fff">
        <section id="contact-us">
            <h1 style="padding-top: 50px">Create New Category</h1>
            @if (Session('status'))
                <span class="notify">{{Session('status')}}</span>
            @endif
            <div class="contact-form">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <span class="error-bag">{{ $message }}</span>
                        @enderror
                    </div>                    

                    <input type="submit" value="submit">
                </form>
            </div>
            <div class="create-categories">
                <a href="{{ route('categories.index') }}" style="color: black">Categories List <span>&#8594</span></a>
            </div>
        </section>
    </main>
@endsection

@section('scripts')
    <script>
        CKEDITOR.replace('body');
    </script>
@endsection
