<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manage Users</title>

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

        .form-control,
        .form-select {
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

        .user-icon {
            width: 38px;
            height: 38px;
            background: #eff6ff;
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
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
            <h2>Manage Users</h2>
            <p>Create, manage and organize your blog users.</p>
        </div>

        <a href="{{ route('adminhome') }}"
           class="btn btn-outline-primary btn-sm">
            <i class="fa-solid fa-house me-1"></i>
            Dashboard
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

        <!-- Create / Edit User Form -->
        <div class="col-lg-4">
            <div class="content-card">

                <h5 class="card-title">
                    @isset($user)
                        <i class="fa-solid fa-user-pen text-primary me-2"></i>
                        Edit User
                    @else
                        <i class="fa-solid fa-user-plus text-primary me-2"></i>
                        Create User
                    @endisset
                </h5>

                <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}"
                      method="POST">

                    @csrf

                    @isset($user)
                        @method('PUT')
                    @endisset

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name *</label>

                        <input type="text"
                               name="name"
                               id="name"
                               class="form-control"
                               placeholder="Enter full name"
                               value="{{ old('name', $user->name ?? '') }}"
                               required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address *</label>

                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control"
                               placeholder="Enter email address"
                               value="{{ old('email', $user->email ?? '') }}"
                               required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Password
                            @empty($user)
                                *
                            @endempty
                        </label>

                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control"
                               placeholder="{{ isset($user) ? 'Leave blank to keep current password' : 'Enter password' }}"
                               {{ isset($user) ? '' : 'required' }}>
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <label for="role" class="form-label">Role *</label>

                        <select name="role" id="role" class="form-select" required>
                            <option value="user"
                                {{ old('role', $user->role ?? 'user') == 'user' ? 'selected' : '' }}>
                                User
                            </option>

                            <option value="admin"
                                {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid {{ isset($user) ? 'fa-pen-to-square' : 'fa-plus' }} me-2"></i>
                            {{ isset($user) ? 'Update User' : 'Create User' }}
                        </button>

                        @isset($user)
                            <a href="{{ route('users.index') }}"
                               class="btn btn-secondary">
                                Cancel
                            </a>
                        @endisset
                    </div>

                </form>

            </div>
        </div>

        <!-- User List -->
        <div class="col-lg-8">
            <div class="content-card">

                <h5 class="card-title">
                    <i class="fa-solid fa-users text-primary me-2"></i>
                    User List
                </h5>

                <div class="table-responsive">
                    <table class="table table-hover">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <span class="user-icon">
                                            <i class="fa-solid fa-user"></i>
                                        </span>

                                        {{ $item->name }}
                                    </td>

                                    <td>{{ $item->email }}</td>

                                    <td>
                                        @if (($item->role ?? 'user') === 'admin')
                                            <span class="badge bg-primary">Admin</span>
                                        @else
                                            <span class="badge bg-secondary">User</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $item->created_at?->format('Y-m-d') ?? '-' }}
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center gap-2">

                                            <!-- Edit Button -->
                                            <a href="{{ route('users.edit', $item) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Edit User">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('users.destroy', $item) }}"
                                                  method="POST"
                                                  class="d-inline mb-0"
                                                  onsubmit="return confirm('Are you sure you want to delete this user?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Delete User">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="text-center text-muted py-4">

                                        <i class="fa-solid fa-users fs-3 d-block mb-2"></i>

                                        No users found.
                                        Create your first user.
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