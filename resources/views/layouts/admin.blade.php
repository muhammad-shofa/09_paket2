<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Parkir - @yield('title')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Puter JS -->
    <script src="https://js.puter.com/v2/"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    colors: {
                        primary: '#4f46e5',
                    }
                }
            }
        }
    </script>
    <!-- Icons (Phosphor) -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    @stack('css')
</head>
<body class="bg-slate-50 text-slate-800 antialiased font-sans flex h-screen overflow-hidden">
    
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
        
        <!-- Navbar -->
        @include('partials.navbar')

        <!-- Main padding -->
        <main class="p-6 sm:p-8 space-y-6">
            @yield('content')
        </main>
    </div>

    <!-- AI Chatbot Component -->
    @include('partials.chatbot')

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @stack('scripts')
</body>
</html>
