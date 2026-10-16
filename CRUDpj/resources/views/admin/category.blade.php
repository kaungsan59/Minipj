<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Categories</title>

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
            padding: 25px;
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

        .form-control {
            padding: 12px;
            font-size: 13px;
            border-radius: 8px;
            border-color: #e2e8f0;
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

        .table {
            font-size: 13px;
            vertical-align: middle;
        }

        .table th {
            color: #64748b;
            font-weight: 600;
            background: #f8fafc;
            padding: 15px;
        }

        .table td {
            padding: 15px;
        }

        .category-icon {
            width: 38px;
            height: 38px;
            background: #eff6ff;
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            margin-right: 10px;
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
            <h2>Manage Categories</h2>
            <p>Create and organize your blog categories.</p>
        </div>

        <a href="{{ route('adminhome') }}"
           class="btn btn-outline-primary btn-sm">
            <i class="fa-solid fa-house me-1"></i> Dashboard
        </a>
    </div>

    <hr>

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

    <div class="row g-4">

        <!-- Create / Edit Category Form -->
        <div class="col-lg-4">
            <div class="content-card">

                <h5 class="card-title">
                    @isset($category)
                        <i class="fa-solid fa-pen-to-square text-primary me-2"></i> Edit Category
                    @else
                        <i class="fa-solid fa-folder-plus text-primary me-2"></i> Create Category
                    @endisset
                </h5>

                <form action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}" method="POST">
                    @csrf
                    @isset($category)
                        @method('PUT')
                    @endisset

                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name *</label>
                        <input type="text"
                            name="name"
                            id="name"
                            class="form-label form-control"
                            placeholder="create category"
                            value="{{ old('name', $category->name ?? '') }}"
                            required>
                    </div>

                    <div class="mb-4">
                        <label for="slug" class="form-label">Slug *</label>
                        <input type="text"
                            name="slug"
                            id="slug"
                            class="form-control"
                            placeholder="Slug will be generated automatically"
                            value="{{ old('slug', $category->slug ?? '') }}"
                            required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid {{ isset($category) ? 'fa-pen-to-square' : 'fa-plus' }} me-2"></i>
                            {{ isset($category) ? 'Update Category' : 'Create Category' }}
                        </button>

                        @isset($category)
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary w-50">Cancel</a>
                        @endisset
                    </div>
                </form>
            </div>
        </div>

        <!-- Category List -->
        <div class="col-lg-8">
            <div class="content-card">

                <h5 class="card-title">
                    <i class="fa-solid fa-folder-open text-primary me-2"></i>
                    Category List
                </h5>

                <div class="table-responsive">
                    <table class="table table-hover">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category Name</th>
                                <th>Slug</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <span class="category-icon">
                                            <i class="fa-solid fa-folder"></i>
                                        </span>

                                        {{ $category->name }}
                                    </td>

                                    <td>
                                        <code>{{ $category->slug }}</code>
                                    </td>

                                    <td>
                                        {{ $category->created_at?->format('Y-m-d') ?? '-' }}
                                    </td>

                                    <td class="align-middle">
                                        <div class="d-flex align-items-center gap-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('categories.edit' , $category) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Edit Category">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <!-- Delete Form -->
                                            <form action="{{ route('categories.destroy', $category) }}"
                                                method="POST"
                                                class="d-inline mb-0"
                                                onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete Category">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="text-center text-muted py-4">

                                        <i class="fa-solid fa-folder-open fs-3 d-block mb-2"></i>

                                        No categories found.
                                        Create your first category.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>

</main>

</body>
</html>