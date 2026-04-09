<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ $role ?? 'Sistem Parkir' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }
        body { background: #f8fafc; color: #1e293b; min-height: 100vh; display: flex; flex-direction: column; }
        
        .navbar {
            background: #ffffff;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand { font-size: 1.25rem; font-weight: 700; color: #4f46e5; }
        
        .user-menu { display: flex; align-items: center; gap: 1.5rem; }
        
        .role-badge {
            background: #e0e7ff;
            color: #4338ca;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .btn-logout {
            background: #ef4444;
            color: white;
            border: none;
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-logout:hover { background: #dc2626; }

        .container {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 2rem;
            width: 100%;
        }

        .welcome-card {
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .welcome-card h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #0f172a;
        }

        .welcome-card p {
            color: #64748b;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="brand">Sistem Parkir</div>
        <div class="user-menu">
            <span class="role-badge">Login: {{ $role ?? 'User' }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-card">
            <h1>Selamat Datang, {{ auth()->user()->nama_lengkap ?? 'User' }}!</h1>
            <p>Anda sedang berada di dashboard utama (Role: {{ auth()->user()->role ?? 'Guest' }}). Silakan gunakan menu navigasi untuk mengelola sistem parkir.</p>
        </div>
    </div>
</body>
</html>
