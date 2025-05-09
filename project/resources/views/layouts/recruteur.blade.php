<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WorkBridge') - Espace Employeur</title>
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
        
        .btn-primary {
            background-color: #4f46e5;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
        }
        
        .nav-link {
            color: #374151;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
            transition: background-color 0.2s;
        }
        
        .nav-link:hover {
            background-color: #f3f4f6;
        }
        
        .nav-link.active {
            background-color: #f3f4f6;
            color: #4f46e5;
            font-weight: 500;
        }
        
        .nav-icon {
            margin-right: 0.75rem;
            width: 1.25rem;
            text-align: center;
        }
        
        .badge {
            position: absolute;
            top: -0.25rem;
            right: -0.25rem;
            background-color: #ef4444;
            color: white;
            font-size: 0.75rem;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            background-color: white;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 12rem;
            z-index: 50;
            overflow: hidden;
        }
        
        .dropdown-item {
            display: block;
            padding: 0.5rem 1rem;
            color: #374151;
            transition: background-color 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: #f3f4f6;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="p-4 flex items-center">
                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center mr-2 text-white font-bold text-xl">
                    WB
                </div>
                <span class="text-xl font-bold text-gray-900">WorkBridge</span>
            </div>
            
            <!-- Divider -->
            <div class="border-t border-gray-200 my-2"></div>
            
            <!-- Create Button -->
            <div class="px-4 mb-4">
                <a href="{{ route('offers.create') }}" class="flex items-center justify-between w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    <span>Créer</span>
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            
            <!-- Navigation Links -->
            <nav class="flex-1 px-2">
                <a href="{{ route('offers.index') }}" class="nav-link {{ request()->routeIs('offres') && !request()->routeIs('offre.create') ? 'active' : '' }}">
                    <i class="fas fa-briefcase nav-icon"></i>
                    <span>Emplois</span>
                </a>
                
                <a href="{{ route('candidatures.index') }}" class="nav-link {{ request()->routeIs('candidature*') ? 'active' : '' }}">
                    <i class="fas fa-user-tie nav-icon"></i>
                    <span>Candidatures</span>
                </a>
                
                <a href="{{ route('offers.index') }}" class="nav-link {{ request()->routeIs('entretien*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check nav-icon"></i>
                    <span>Entretiens</span>
                </a>
                
                <a href="{{ route('offers.index') }}" class="nav-link {{ request()->routeIs('analyse*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar nav-icon"></i>
                    <span>Analyses</span>
                </a>
            </nav>
            
            <!-- Bottom Links -->
            <div class="px-2 mb-6">
                <div class="border-t border-gray-200 my-2"></div>
                
                <a href="{{ route('recruiter.profile') }}" class="nav-link {{ request()->routeIs('recruiter.profile*') ? 'active' : '' }}">
                    <i class="fas fa-building nav-icon"></i>
                    <span>Profil Entreprise</span>
                </a>
                
                <a href="{{ route('recruiter.profile') }}" class="nav-link {{ request()->routeIs('employer.settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog nav-icon"></i>
                    <span>Paramètres</span>
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 py-4 px-6 flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-800">@yield('header-title', 'Tableau de bord')</h1>
                
                <div class="flex items-center space-x-6">        
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                            <img src="https://ui-avatars.com/api/?name=T&background=4f46e5&color=fff" alt="Profile" class="h-8 w-8 rounded-full">
                            <span class="font-medium">testo</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="dropdown-menu">
                            <a href="{{ route('recruiter.profile') }}" class="dropdown-item">
                                <i class="fas fa-user-circle mr-2"></i> Profil
                            </a>
                            <div class="border-t border-gray-200"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item w-full text-left">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 p-6 bg-gray-50 overflow-y-auto">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-6 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} WorkBridge, Inc. Tous droits réservés.
            </footer>
        </div>
    </div>

    <!-- Alpine.js for dropdown functionality -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @yield('scripts')
</body>
</html>