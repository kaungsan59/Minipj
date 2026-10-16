
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} | MyBlog</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5" style="max-width: 850px;">

    <a href="{{ route('user.index') }}"
       class="btn btn-outline-primary mb-4">
        &larr; Back to Posts
    </a>

    <article class="bg-white rounded-4 shadow-sm p-4 p-md-5">

        <p class="text-secondary">
            Published on {{ $post->created_at?->format('F d, Y') }}
        </p>

        <h1 class="fw-bold mb-4">{{ $post->title }}</h1>

        @if (!empty($post->image))
            <img src="{{ asset('storage/' . $post->image) }}"
                 alt="{{ $post->title }}"
                 class="img-fluid rounded-3 mb-4 w-100">
        @endif

        <div style="line-height: 1.9; white-space: pre-line;">
            {{ $post->body }}
        </div>

    </article>

</div>

</body>
</html>
