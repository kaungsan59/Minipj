<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($post) ? 'Edit Post' : 'Create Post' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            background: #f0f4ff;
            color: #1e293b;
        }

        .main-content {
            padding: 35px;
            max-width: 1000px;
            margin: auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            gap: 15px;
        }

        .page-header h2 {
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .page-header p {
            color: #64748b;
            font-size: 13px;
            margin: 0;
        }

        .content-card {
            background: white;
            border-radius: 14px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(50, 80, 150, 0.05);
            margin-bottom: 25px;
        }

        .card-title {
            font-size: 17px;
            font-weight: 600;
            margin-bottom: 22px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            padding: 12px;
            font-size: 13px;
            border-radius: 8px;
            border-color: #e2e8f0;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            border-color: #2563eb;
        }

        .btn-primary {
            background: #2563eb;
            border-color: #2563eb;
            border-radius: 8px;
            padding: 11px 18px;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 18px 12px;
            }

            .content-card {
                padding: 20px;
            }

            .page-header h2 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
<main class="main-content">

    <div class="page-header">
        <div>
            <h2>{{ isset($post) ? 'Edit Post' : 'Create New Post' }}</h2>
            <p>{{ isset($post) ? 'Update your blog post details.' : 'Write and publish a new blog post.' }}</p>
        </div>

        <a href="{{ route('posts.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Back to Posts
        </a>
    </div>

    <hr>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="content-card">

        <h5 class="card-title">
            <i class="fa-solid {{ isset($post) ? 'fa-pen-to-square' : 'fa-plus' }} text-primary me-2"></i>
            {{ isset($post) ? 'Edit Post Details' : 'Post Details' }}
        </h5>

        <form action="{{ isset($post) ? route('posts.update', $post) : route('posts.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            @isset($post)
                @method('PUT')
            @endisset

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label">Post Title *</label>
                    <input type="text"
                           name="title"
                           id="title"
                           class="form-control"
                           placeholder="Enter post title"
                           value="{{ old('title', $post->title ?? '') }}"
                           required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="slug" class="form-label">Slug *</label>
                    <input type="text"
                           name="slug"
                           id="slug"
                           class="form-control"
                           placeholder="e.g. my-first-post"
                           value="{{ old('slug', $post->slug ?? '') }}"
                           required>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Category *</label>

                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">Select category</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('category_id', $post->category_id ?? '') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                

            </div>

            <div class="mb-4">
                <label for="body" class="form-label">Post Body *</label>

                <textarea name="body"
                          id="body"
                          rows="7"
                          class="form-control"
                          placeholder="Write your blog content here..."
                          required>{{ old('body', $post->body ?? '') }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="fa-solid {{ isset($post) ? 'fa-save' : 'fa-paper-plane' }} me-2"></i>
                    {{ isset($post) ? 'Update Post' : 'Publish Post' }}
                </button>

                @isset($post)
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                @endisset
            </div>

        </form>
    </div>
</main>
</body>
</html>