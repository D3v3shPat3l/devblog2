@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Posts</h1>
    @foreach ($posts as $post)
        <div class="card mb-3">
            <div class="card-header">
                {{ $post->title }} by {{ $post->user->name }}
            </div>
            <div class="card-body">
                <p>{{ $post->content }}</p>
                <a href="{{ route('posts.show', $post) }}" class="btn btn-primary">View</a>
            </div>
        </div>
    @endforeach
    <a href="{{ route('posts.create') }}" class="btn btn-success">Create New Post</a>
</div>
@endsection
