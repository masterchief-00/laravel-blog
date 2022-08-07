@extends('layouts.layout')

@section('main')
    @if (Session('status'))
        <span class="notify">{{ Session('status') }}</span>
    @endif
    <div class="categories-list">
        @foreach ($categories as $category)
            <div class="item">
                <div>
                    <p>{{ $category->name }}</p>
                </div>
                <div class="category-buttons">
                    <a href="{{ route('categories.edit', $category) }}">Edit</a>
                    <form action="{{ route('categories.destroy',$category) }}" method="POST">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Delete">
                    </form>
                </div>
            </div>
        @endforeach
        <div class="index-categories">
            <a href="{{ route('categories.create') }}">Create category <span>&#8594</span></a>
        </div>
    </div>
@endsection)
