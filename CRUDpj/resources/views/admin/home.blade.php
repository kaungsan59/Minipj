<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            background: #f0f4ff;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid #dce2ee;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: fixed;
            height: 100%;
        }

        .sidebar-brand {
            padding: 24px;
            font-size: 20px;
            font-weight: 700;
            color: #2563eb;
            border-bottom: 1px solid #f0f4ff;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0 15px;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar-menu li {
            margin-bottom: 8px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #555;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: 0.2s;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: #2563eb;
            color: white;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #f0f4ff;
        }

        .logout-btn {
            width: 100%;
            padding: 10px;
            background: #fee2e2;
            color: #dc2626;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #fecaca;
        }

        /* Main Content Styling */
        .main-content {
            margin-left: 260px;
            flex-grow: 1;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 24px;
            color: #1e293b;
            margin: 0;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            color: #444;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(50, 80, 150, 0.05);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 22px;
            color: #1e293b;
        }

        .stat-info p {
            margin: 0;
            font-size: 12px;
            color: #888;
        }

        /* Recent Table Section */
        .content-box {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(50, 80, 150, 0.05);
        }

        .content-box h2 {
            font-size: 18px;
            color: #1e293b;
            margin-top: 0;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 13px;
        }

        th {
            color: #64748b;
            font-weight: 600;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
        }

        td {
            padding: 14px 0;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            background: #e2e8f0;
            color: #475569;
        }

        .badge.published {
            background: #dcfce7;
            color: #16a34a;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <div class="sidebar-brand">Blog</div>
            <ul class="sidebar-menu">
                <li><a href="#" class="active"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li><a href="{{ route('posts.index') }}"><i class="fa-solid fa-file-pen"></i> Add New Post</a></li>
                <li><a href="{{ route('categories.index') }}"><i class="fa-solid fa-plus"></i> Add New Category</a></li>
                <li><a href="{{ route('users.index') }}"><i class="fa-solid fa-users"></i> Users</a></li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Top Header -->
        <div class="header">
            <h1>Dashboard Overview</h1>
            <div class="admin-profile" style="display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-user-circle" style="font-size: 22px; color: #2563eb;"></i>
            <span>{{ Auth()->user()->name ?? 'Admin' }}</span>
            </div>
        </div><hr>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-newspaper"></i></div>
                <div class="stat-info">
                    <h3>{{ $totalposts }}</h3>
                    <p>Total Posts</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div class="stat-info">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
            </div>
        </div>

        <!-- Recent Posts Table 
        <div class="content-box">
            <h2>Recent Posts</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Getting Started with Laravel</td>
                        <td>Admin</td>
                        <td><span class="badge published">Published</span></td>
                        <td>2026-10-13</td>
                    </tr>
                </tbody>
            </table>
        </div> -->
    </div>

</body>
</html>