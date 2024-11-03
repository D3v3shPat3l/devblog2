<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }}'s Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center flex flex-col items-center min-h-screen" style="background-image: url('/images/background.jpg');">

    <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg max-w-2xl w-full">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">{{ $user->name }}'s History</h1>

        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Posts</h2>
        @if($posts->isEmpty())
            <p class="text-gray-600 text-center">No posts found.</p>
        @else
            @foreach($posts as $post)
                <div class="bg-gray-100 p-4 rounded-lg shadow mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $post->title }}</h3>
                    <p class="text-gray-700">{{ $post->content }}</p>
                    <p class="text-sm text-gray-500 mt-2">Posted on {{ $post->created_at->format('M d, Y') }}</p>

                    <!-- Comments Section -->
                    <div class="mt-4">
                        <h4 class="text-lg font-semibold text-gray-800">Comments</h4>
                        @if($post->comments->isEmpty())
                            <p class="text-gray-600">No comments yet.</p>
                        @else
                            @foreach($post->comments as $comment)
                                <div class="bg-white p-2 mt-2 rounded-lg shadow-sm">
                                    <p class="text-gray-700">{{ $comment->content }}</p>
                                    <p class="text-xs text-gray-500">Commented on {{ $comment->created_at->format('M d, Y') }}</p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        @endif

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">All Comments</h2>
        @if($comments->isEmpty())
            <p class="text-gray-600 text-center">No comments found.</p>
        @else
            @foreach($comments as $comment)
                <div class="bg-gray-100 p-4 rounded-lg shadow mb-6">
                    <p class="text-gray-700">{{ $comment->content }}</p>
                    <p class="text-xs text-gray-500">Commented on {{ $comment->created_at->format('M d, Y') }}</p>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>
