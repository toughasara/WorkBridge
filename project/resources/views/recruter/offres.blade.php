@extends('layouts.recruteur')

@section('title', 'Gestion des offres d\'emploi')

@section('styles')
<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .filters-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        align-items: center;
    }
    
    .filter-badge {
        display: inline-flex;
        align-items: center;
        background-color: #2557a7;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-weight: 500;
    }
    
    .filter-select {
        min-width: 180px;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: white;
    }
    
    .search-container {
        display: flex;
        margin-left: auto;
    }
    
    .search-input {
        padding: 0.5rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem 0 0 0.375rem;
        min-width: 250px;
    }
    
    .search-button {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f3f4f6;
        border: 1px solid #d1d5db;
        border-left: none;
        border-radius: 0 0.375rem 0.375rem 0;
        padding: 0 0.75rem;
        cursor: pointer;
    }
    
    .search-button:hover {
        background-color: #e5e7eb;
    }
    
    .table-container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }
    
    .offers-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .offers-table th {
        background-color: #f9fafb;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 500;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .offers-table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
    }
    
    .offers-table tr:last-child td {
        border-bottom: none;
    }
    
    .offers-table tr:hover {
        background-color: #f9fafb;
    }
    
    .sortable {
        cursor: pointer;
        position: relative;
    }
    
    .sortable::after {
        content: '↕';
        position: absolute;
        right: 0.5rem;
        color: #9ca3af;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .status-published {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-draft {
        background-color: #e5e7eb;
        color: #4b5563;
    }
    
    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .status-closed {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .status-suspended {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .action-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 0.25rem;
    }
    
    .action-button:hover {
        background-color: #f3f4f6;
    }
    
    .dropdown {
        position: relative;
        display: inline-block;
    }
    
    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        bottom: auto;
        min-width: 200px;
        background-color: white;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border-radius: 0.375rem;
        z-index: 10;
        /* Assurez-vous que le dropdown reste visible même en bas de la table */
        transform: translateY(0);
    }

    /* Pour les dernières lignes, afficher le dropdown vers le haut */
    tr:nth-last-child(-n+2) .dropdown-content {
        bottom: 100%;
        top: auto;
        margin-bottom: 5px;
    }
    
    .dropdown-content a {
        display: block;
        padding: 0.75rem 1rem;
        color: #374151;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    
    .dropdown-content a:hover {
        background-color: #f3f4f6;
    }
    
    .show {
        display: block;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6b7280;
    }
    
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }
    
    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #4b5563;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }
    
    .btn-primary:hover {
        background-color: #374151;
    }
    
    .info-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #eff6ff;
        color: #1e40af;
        border-radius: 9999px;
        width: 1.5rem;
        height: 1.5rem;
        font-size: 0.75rem;
        margin-left: 0.5rem;
    }
    
    .application-count {
        font-weight: 500;
    }
    
    .application-message {
        color: #6b7280;
        font-size: 0.875rem;
        font-style: italic;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto py-6 px-4">
    <!-- Header -->
    <div class="header-container">
        <h1 class="text-2xl font-bold text-gray-900">Emplois</h1>
        <a href="{{ route('offers.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle mr-2"></i>
            Publier une offre d'emploi
        </a>
    </div>
    
    <!-- Filters -->
    <div class="filters-container">
        <div class="filter-badge">
            Nouveau
        </div>
        
        <select class="filter-select" id="status-filter">
            <option value="">Statut (Tous)</option>
            <option value="publiée" {{ request('status') == 'publiée' ? 'selected' : '' }}>Publiée</option>
            <option value="brouillon" {{ request('status') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
            <option value="en attente" {{ request('status') == 'en attente' ? 'selected' : '' }}>En attente</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            <option value="suspendu" {{ request('status') == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
        </select>
        
        <div class="search-container">
            <input type="text" class="search-input" id="search-input" placeholder="Rechercher des offres..." value="{{ request('search') }}">
            <button class="search-button" id="search-button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    
    <!-- Table -->
    <div class="table-container">
        @if(count($offres) > 0)
            <table class="offers-table">
                <thead>
                    <tr>
                        <th class="sortable" data-sort="title">Intitulé du poste</th>
                        <th>Candidatures</th>
                        <th class="sortable" data-sort="created_at">Date de publication</th>
                        <th>Statut de l'emploi</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offres as $offre)
                        <tr>
                            <td>
                                <div class="font-medium">{{ $offre->title }}</div>
                                <div class="text-sm text-gray-500">{{ $offre->location }}</div>
                            </td>
                            <td>
                                @if($offre->applications_count > 0)
                                    <span class="application-count">{{ $offre->applications_count }}</span>
                                @else
                                    @if($offre->statut == 'publiée')
                                        <span class="application-message">Aucune candidature pour le moment</span>
                                    @elseif($offre->statut == 'brouillon')
                                        <span class="application-message">L'offre n'est pas encore publiée</span>
                                    @elseif($offre->statut == 'rejected')
                                        <span class="application-message">Votre Offre n'a pas accepter</span>
                                    @elseif($offre->statut == 'en attente')
                                        <span class="application-message">Votre offre d'emploi n'est pas encore publiée sur WorkBridge</span>
                                    @else
                                        <span class="application-message">Aucune candidature</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($offre->created_at)
                                    {{ $offre->created_at->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($offre->statut == 'publiée')
                                    <span class="status-badge status-published">Publiée</span>
                                @elseif($offre->statut == 'brouillon')
                                    <span class="status-badge status-draft">Brouillon</span>
                                @elseif($offre->statut == 'en attente')
                                    <span class="status-badge status-pending">En attente</span>
                                @elseif($offre->statut == 'rejected')
                                    <span class="status-badge status-closed">Rejectede</span>
                                @elseif($offre->statut == 'suspendu')
                                    <span class="status-badge status-suspended">Suspendue</span>
                                @else
                                    <span class="status-badge">{{ $offre->statut }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="action-button" onclick="toggleDropdown('dropdown-{{ $offre->id }}')">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div id="dropdown-{{ $offre->id }}" class="dropdown-content">
                                        <a href="{{ route('offers.edit', $offre->id) }}">
                                            <i class="fas fa-edit mr-2"></i> Modifier l'emploi
                                        </a>
                                        <a href="{{ route('offers.show', $offre->id) }}">
                                            <i class="fas fa-eye mr-2"></i> Voir les détails
                                        </a>
                                        @if($offre->statut == 'brouillon')
                                            <a href="#">
                                                <i class="fas fa-paper-plane mr-2"></i> Publier l'offre
                                            </a>
                                        @endif
                                        @if($offre->statut == 'publiée')
                                            <a href="#">
                                                <i class="fas fa-times-circle mr-2"></i> Fermer l'offre
                                            </a>
                                        @endif
                                        <a href="#" onclick="confirmDelete('{{ $offre->id }}')">
                                            <i class="fas fa-trash-alt mr-2"></i> Supprimer
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3 class="text-lg font-medium mb-2">Aucune offre d'emploi</h3>
                <p class="mb-4">Vous n'avez pas encore créé d'offre d'emploi.</p>
                <a href="{{ route('offers.create') }}" class="btn-primary">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Créer une offre d'emploi
                </a>
            </div>
        @endif
    </div>
    
    <!-- Pagination -->
    @if(count($offres) > 0)
        <div class="mt-4">
            {{ $offres->links() }}
        </div>
    @endif
    
    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-medium mb-4">Confirmer la suppression</h3>
            <p class="mb-6">Êtes-vous sûr de vouloir supprimer cette offre d'emploi ? Cette action est irréversible.</p>
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700" onclick="closeDeleteModal()">Annuler</button>
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Toggle dropdown menu
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        dropdown.classList.toggle('show');
        
        // Assurez-vous que le dropdown est visible dans la fenêtre
        if (dropdown.classList.contains('show')) {
            const rect = dropdown.getBoundingClientRect();
            const viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
            
            // Si le dropdown dépasse le bas de l'écran, l'afficher vers le haut
            if (rect.bottom > viewHeight) {
                dropdown.style.bottom = '100%';
                dropdown.style.top = 'auto';
                dropdown.style.marginBottom = '5px';
            } else {
                dropdown.style.top = 'auto';
                dropdown.style.bottom = 'auto';
            }
        }
        
        // Close other dropdowns
        const dropdowns = document.getElementsByClassName('dropdown-content');
        for (let i = 0; i < dropdowns.length; i++) {
            const openDropdown = dropdowns[i];
            if (openDropdown.id !== id && openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
    
    // Close dropdowns when clicking outside
    window.onclick = function(event) {
        if (!event.target.matches('.action-button') && !event.target.matches('.fa-ellipsis-v')) {
            const dropdowns = document.getElementsByClassName('dropdown-content');
            for (let i = 0; i < dropdowns.length; i++) {
                const openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
    
    // Handle search
    document.getElementById('search-button').addEventListener('click', function() {
        const searchValue = document.getElementById('search-input').value;
        const statusValue = document.getElementById('status-filter').value;
        
        let url = '{{ route("offers.index") }}?';
        if (searchValue) {
            url += 'search=' + encodeURIComponent(searchValue);
        }
        
        if (statusValue) {
            url += (searchValue ? '&' : '') + 'status=' + encodeURIComponent(statusValue);
        }
        
        window.location.href = url;
    });
    
    // Handle status filter change
    document.getElementById('status-filter').addEventListener('change', function() {
        const searchValue = document.getElementById('search-input').value;
        const statusValue = this.value;
        
        let url = '{{ route("offers.index") }}?';
        if (statusValue) {
            url += 'status=' + encodeURIComponent(statusValue);
        }
        
        if (searchValue) {
            url += (statusValue ? '&' : '') + 'search=' + encodeURIComponent(searchValue);
        }
        
        window.location.href = url;
    });
    
    // Handle enter key in search input
    document.getElementById('search-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('search-button').click();
        }
    });
    
    // Handle sorting
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function() {
            const sort = this.dataset.sort;
            const currentSort = new URLSearchParams(window.location.search).get('sort') || '';
            const currentDirection = new URLSearchParams(window.location.search).get('direction') || 'asc';
            
            let direction = 'asc';
            if (sort === currentSort && currentDirection === 'asc') {
                direction = 'desc';
            }
            
            const searchValue = document.getElementById('search-input').value;
            const statusValue = document.getElementById('status-filter').value;
            
            let url = '{{ route("offers.index") }}?sort=' + sort + '&direction=' + direction;
            
            if (searchValue) {
                url += '&search=' + encodeURIComponent(searchValue);
            }
            
            if (statusValue) {
                url += '&status=' + encodeURIComponent(statusValue);
            }
            
            window.location.href = url;
        });
    });
    
    // Delete confirmation
    function confirmDelete(id) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        
        form.action = '{{ route("offers.index") }}/' + id;
        modal.classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('hidden');
    }
</script>
@endsection

