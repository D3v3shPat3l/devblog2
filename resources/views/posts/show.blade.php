@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>
    <p>by {{ $post->user->name }}</p>
    <p>{{ $post->content }}</p>

    <h2>Comments</h2>
    @foreach ($post->comments as $comment)
        <div class="card mb-2">
            <div class="card-body">
                <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
            </div>
        </div>
    @endforeach

    <form action="{{ route('comments.store', $post) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="content" class="form-label">Add a Comment</label>
            <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Comment</button>
    </form>
</div>
@endsection
