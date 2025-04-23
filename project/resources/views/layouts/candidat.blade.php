<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WorkBridge') - Connect with Top Talent</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        .auth-card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .form-input {
            @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500;
        }
        .btn-primary {
            @apply bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out;
        }
        .btn-secondary {
            @apply bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out;
        }
        .btn-outline {
            @apply border border-indigo-500 text-indigo-600 hover:bg-indigo-50 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out;
        }
        .nav-link {
            @apply text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium;
        }
        .nav-link.active {
            @apply text-indigo-600 border-b-2 border-indigo-600;
        }
        .nav-icon {
            @apply text-gray-700 hover:text-indigo-600 p-2 rounded-full hover:bg-gray-100;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center mr-2">
                            <span class="text-xl font-bold text-white">WB</span>
                        </div>
                        <span class="text-xl font-bold text-gray-900">WorkBridge</span>
                    </a>
                    
                    <!-- Navigation Links -->
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('candidat.offres.index') }}" class="nav-link {{ request()->routeIs('candidat.offres.index') ? 'active' : '' }}">
                            Page d'accueil
                        </a>
                        
                        <!-- <a href="{{ route('saved.jobs') }}" class="nav-link {{ request()->routeIs('saved.jobs') ? 'active' : '' }}">
                            Postes enregistrés
                        </a> -->
                    </div>
                </div>
                
                <!-- Right Side Icons -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('messages') }}" class="nav-icon" title="Messages">
                        <i class="fas fa-comment-alt"></i>
                    </a>
                    <a href="{{ route('notifications') }}" class="nav-icon" title="Notifications">
                        <i class="fas fa-bell"></i>
                    </a>
                    <div class="relative">
                        <a href="{{ route('profil.candidat') }}" class="nav-icon" title="Profil">
                            <i class="fas fa-user-circle text-xl"></i>
                        </a>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="ml-2">
                        @csrf
                        <button type="submit" class="nav-link">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white">
        <div class="max-w-7xl mx-auto py-6 px-4 overflow-hidden sm:px-6 lg:px-8">
            <p class="text-center text-base text-gray-400">
                &copy; 2023 WorkBridge, Inc. All rights reserved.
            </p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
