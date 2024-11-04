<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center flex flex-col items-center min-h-screen" style="background-image: url('/images/background.jpg');">

    <!-- Logout Button -->
    <div class="w-full max-w-2xl flex justify-end p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Log Out
            </button>
        </form>
    </div>

    <!-- Main Dashboard Content -->
    <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg max-w-2xl w-full">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Welcome to Your Dashboard</h1>
        <p class="text-gray-600 text-center mb-6">Share your thoughts and engage with the community!</p>

        <!-- Post Creation Form -->
        <form action="{{ route('posts.store') }}" method="POST" class="mb-6">
            @csrf
            <div class="mb-4">
                <input type="text" name="title" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Post title" required>
            </div>
            <div class="mb-4">
                <textarea name="content" rows="3" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="What's on your mind?" required></textarea>
            </div>
            <button type="submit" class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Post
            </button>
        </form>

        <!-- Display Posts and Comments -->
        <div>
            @foreach($posts as $post)
                <div class="bg-gray-100 p-4 rounded-lg shadow mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $post->title }}</h2>
                    <p class="text-gray-700">{{ $post->content }}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        Posted by 
                        <a href="{{ route('users.show', $post->user->id) }}" class="text-indigo-600 hover:underline">{{ $post->user->name }}</a> 
                        on {{ $post->created_at->format('M d, Y') }}
                    </p>

                    <!-- Comments Section -->
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-800">Comments</h3>
                        @foreach($post->comments as $comment)
                            <div class="bg-white p-2 mt-2 rounded-lg shadow-sm">
                                <p class="text-gray-700">{{ $comment->content }}</p>
                                <p class="text-xs text-gray-500">Commented by 
                                    <a href="{{ route('users.show', $comment->user->id) }}" class="text-indigo-600 hover:underline">{{ $comment->user->name }}</a> 
                                    on {{ $comment->created_at->format('M d, Y') }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Comment Form -->
                    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-4">
                        @csrf
                        <textarea name="content" rows="2" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Write a comment..." required></textarea>
                        <button type="submit" class="w-full mt-2 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                            Comment
                        </button>
                    </form>

                    <!-- Edit and Delete Buttons (only for admin or the original author) -->
                    @if(auth()->user()->hasRole('admin') || auth()->user()->id == $post->user_id)
                        <div class="flex space-x-2 mt-4">
                            <a href="{{ route('posts.edit', $post->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                Edit
                            </a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
