<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>Welcome to the Main Page</h1>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <h2>Create a Post</h2>
    <form action="{{ route('posts.create') }}" method="POST">
        @csrf
        <input type="text" name="title" placeholder="Post Title" required>
        <textarea name="content" placeholder="Post Content" required></textarea>
        <button type="submit">Create Post</button>
    </form>

    <h2>Posts</h2>
    @foreach($posts as $post)
        <div>
            <h3>{{ $post->title }} by {{ $post->user->name }}</h3>
            <p>{{ $post->content }}</p>

            <h4>Comments</h4>
            <form action="{{ route('comments.store', $post->id) }}" method="POST">
                @csrf
                <textarea name="content" placeholder="Comment..." required></textarea>
                <button type="submit">Add Comment</button>
            </form>
            @foreach($post->comments as $comment)
                <div>
                    <strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}
                </div>
            @endforeach
        </div>
    @endforeach
</body>
</html>
