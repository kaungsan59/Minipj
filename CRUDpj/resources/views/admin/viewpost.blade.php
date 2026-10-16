<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Posts</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

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
            max-width: 1250px;
            margin: auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 28px;
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
            padding: 25px;
            box-shadow: 0 4px 20px rgba(50, 80, 150, 0.05);
        }

        .card-title {
            font-size: 17px;
            font-weight: 600;
            margin-bottom: 22px;
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
        }

        .table {
            font-size: 13px;
            vertical-align: middle;
        }

        .table th {
            color: #64748b;
            font-weight: 600;
            background: #f8fafc;
            padding: 15px;
            white-space: nowrap;
        }

        .table td {
            padding: 15px;
        }

        .post-title {
            font-weight: 600;
            color: #1e293b;
        }

        .slug {
            color: #64748b;
            font-size: 12px;
        }

        .status-badge {
            background: #dcfce7;
            color: #15803d;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 18px 12px;
            }

            .content-card {
                padding: 16px;
            }

            .page-header h2 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>

    <main class="main-content">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h2>Manage Posts</h2>
                <p>Create, manage and organize your blog posts.</p>
            </div>

            <div class="d-flex gap-2">

                <!-- Dashboard Button -->
                <a href="{{ route('adminhome') }}"
                    class="btn btn-outline-primary">
                    <i class="fa-solid fa-house me-2"></i>
                    Dashboard
                </a>

                <!-- Create Post Button -->
                <a href="{{ route('posts.create') }}"
                    class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>
                    Create Post
                </a>

            </div>
        </div>
        <hr class="mb-4">

        <!-- Success Message -->
        @if (session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
        </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Post List -->
        <div class="content-card">

            <h5 class="card-title">
                <i class="fa-solid fa-newspaper text-primary me-2"></i>
                Post List
            </h5>

            <div class="table-responsive">
                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Post Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($posts as $post)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <div class="post-title">
                                    {{ $post->title }}
                                </div>

                                <div class="slug">
                                    {{ $post->slug }}
                                </div>
                            </td>

                            <td>
                                {{ $post->category?->name ?? 'No Category' }}
                            </td>

                            <td>
                                {{ $post->user?->name ?? 'Unknown' }}
                            </td>

                            <td>
                                {{ $post->created_at?->format('Y-m-d') ?? '-' }}
                            </td>

                            <td>
                                <div class="d-flex gap-2">

                                    <!-- Edit -->
                                    <a href="{{ route('posts.edit', $post->id) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Edit Post">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('posts.destroy', $post->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this post?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Delete Post">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <td colspan="6"
                                class="text-center text-muted py-5">

                                <i class="fa-solid fa-newspaper fs-2 d-block mb-3"></i>

                                <p class="mb-2">No posts found.</p>

                                <a href="{{ route('posts.create') }}"
                                    class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-plus me-1"></i>
                                    Create Your First Post
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </main>

</body>

</html>