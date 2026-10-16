<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Blog | Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: #f5f7fb;
            color: #1e293b;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #fff;
            box-shadow: 0 2px 12px rgba(0,0,0,.06);
        }

        .brand {
            color: #2563eb;
            font-size: 24px;
            font-weight: bold;
        }

        .hero {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            color: white;
            padding: 65px 25px;
            border-radius: 18px;
            margin: 30px 0;
        }

        .hero h1 {
            font-size: 38px;
            font-weight: bold;
        }

        .post-card {
            height: 100%;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0,0,0,.05);
            transition: transform .2s;
        }

        .post-card:hover {
            transform: translateY(-5px);
        }

        .post-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #e2e8f0;
        }

        .post-title {
            font-size: 20px;
            font-weight: bold;
        }

        .post-description {
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
        }

        .read-btn {
            background: #2563eb;
            color: white;
            border-radius: 8px;
            padding: 9px 16px;
            text-decoration: none;
            display: inline-block;
        }

        .read-btn:hover {
            background: #1d4ed8;
            color: white;
        }

        footer {
            margin-top: 60px;
            padding: 25px;
            text-align: center;
            background: white;
            color: #64748b;
        }

        @media (max-width: 576px) {
            .hero h1 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a href="{{ route('user.index') }}"
           class="navbar-brand brand">
            <i class="fa-solid fa-book-open me-2"></i>MyBlog
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                <li class="nav-item">
                    <a href="{{ route('user.index') }}"
                       class="nav-link active">Home</a>
                </li>

                <li class="nav-item">
                    <span class="nav-link">
                        <i class="fa-solid fa-user me-1"></i>
                        {{ auth()->user()->name }}
                    </span>
                </li>

                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm"
                                type="submit">
                            <i class="fa-solid fa-right-from-bracket me-1"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container">

    <!-- Welcome Section -->
    <section class="hero">
        <h1>Welcome, {{ auth()->user()->name }}!</h1>

        <p class="mt-3 mb-0">
            Discover interesting articles, learn something new,
            and explore all our latest blog posts.
        </p>

        <a href="#posts" class="btn btn-light mt-4">
            <i class="fa-solid fa-book-open me-2"></i>
            Explore Posts
        </a>
    </section>

    <!-- Posts Section -->
    <section id="posts" class="mb-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Latest Posts</h2>
                <p class="text-secondary mb-0">
                    Read all articles published on our blog.
                </p>
            </div>

            <span class="badge bg-primary fs-6">
                {{ $posts->count() }} Posts
            </span>
        </div>

        <div class="row g-4">

            @forelse ($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card post-card">

                        @if (!empty($post->image))
                            <img
                                src="{{ asset('storage/' . $post->image) }}"
                                class="post-image"
                                alt="{{ $post->title }}">
                        @else
                            <div class="post-image d-flex align-items-center justify-content-center">
                                <i class="fa-solid fa-newspaper fa-3x text-secondary"></i>
                            </div>
                        @endif

                        <div class="card-body p-4 d-flex flex-column">

                            <div class="text-secondary small mb-3">
                                <i class="fa-regular fa-calendar me-1"></i>
                                {{ $post->created_at?->format('M d, Y') }}

                                @if ($post->user)
                                    <span class="ms-2">
                                        <i class="fa-regular fa-user me-1"></i>
                                        {{ $post->user->name }}
                                    </span>
                                @endif
                            </div>

                            <h5 class="post-title">
                                {{ $post->title }}
                            </h5>

                            <p class="post-description">
                                {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                            </p>

                            <div class="mt-auto">
                                <a href="{{ route('user.posts.show', $post) }}"
                                   class="read-btn">
                                    Read More
                                    <i class="fa-solid fa-arrow-right ms-1"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

            @empty
                <div class="col-12">
                    <div class="bg-white text-center p-5 rounded-4">
                        <i class="fa-solid fa-newspaper fa-3x text-secondary mb-3"></i>
                        <h4>No Posts Available</h4>
                        <p class="text-secondary mb-0">
                            There are no blog posts to read yet.
                        </p>
                    </div>
                </div>
            @endforelse

        </div>

    </section>
</main>

<footer>
    <p class="mb-0">
        &copy; {{ date('Y') }} MyBlog. All rights reserved.
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>