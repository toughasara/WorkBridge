@extends('layouts.admin')

@section('title', 'Gestion des recruteurs')

@section('header-title', 'Gestion des recruteurs')

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
    
    .recruiters-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .recruiters-table th {
        background-color: #f9fafb;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 500;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .recruiters-table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
    }
    
    .recruiters-table tr:last-child td {
        border-bottom: none;
    }
    
    .recruiters-table tr:hover {
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
    
    .status-active {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-suspended {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
        font-size: 0.875rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
    }
    
    .btn-primary {
        background-color: #4f46e5;
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #4338ca;
    }
    
    .btn-danger {
        background-color: #ef4444;
        color: white;
    }
    
    .btn-danger:hover {
        background-color: #dc2626;
    }
    
    .btn-warning {
        background-color: #f59e0b;
        color: white;
    }
    
    .btn-warning:hover {
        background-color: #d97706;
    }
    
    .btn-success {
        background-color: #10b981;
        color: white;
    }
    
    .btn-success:hover {
        background-color: #059669;
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
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .company-info {
        display: flex;
        align-items: center;
    }
    
    .company-logo {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        font-weight: bold;
        color: #4f46e5;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto py-6 px-4">
    <!-- Header -->
    <div class="header-container">
        <h1 class="text-2xl font-bold text-gray-900">Gestion des recruteurs</h1>
    </div>
    
    <!-- Filters -->
    <div class="filters-container">
        <select class="filter-select" id="status-filter">
            <option value="">Statut (Tous)</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspendu</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
        </select>
        
        <div class="search-container">
            <input type="text" class="search-input" id="search-input" placeholder="Rechercher des recruteurs..." value="{{ request('search') }}">
            <button class="search-button" id="search-button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    
    <!-- Table -->
    <div class="table-container">
        @if(count($recruiters) > 0)
            <table class="recruiters-table">
                <thead>
                    <tr>
                        <th class="sortable" data-sort="name">Entreprise / Recruteur</th>
                        <th>Email</th>
                        <th class="sortable" data-sort="created_at">Date d'inscription</th>
                        <th>Offres publiées</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recruiters as $recruiter)
                        <tr>
                            <td>
                                <div class="company-info">
                                    <div class="company-logo">
                                        @if($recruiter->company && $recruiter->company->logo)
                                            <img src="{{ asset('storage/' . $recruiter->company->logo) }}" alt="{{ $recruiter->company->name }}" class="w-full h-full object-cover rounded-md">
                                        @else
                                            {{ substr($recruiter->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $recruiter->company ? $recruiter->company->name : $recruiter->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $recruiter->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $recruiter->email }}</td>
                            <td>{{ $recruiter->created_at->format('d/m/Y') }}</td>
                            <td>{{ $recruiter->offers_count ?? 0 }}</td>
                            <td>
                                @if($recruiter->status == 'active')
                                    <span class="status-badge status-active">Actif</span>
                                @elseif($recruiter->status == 'suspended')
                                    <span class="status-badge status-suspended">Suspendu</span>
                                @elseif($recruiter->status == 'pending')
                                    <span class="status-badge status-pending">En attente</span>
                                @else
                                    <span class="status-badge">{{ $recruiter->status }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if($recruiter->status == 'active')
                                        <form action="{{ route('admin.recruiters.suspend', $recruiter->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Êtes-vous sûr de vouloir suspendre ce compte ?')">
                                                <i class="fas fa-ban mr-1"></i> Suspendre
                                            </button>
                                        </form>
                                    @elseif($recruiter->status == 'suspended' || $recruiter->status == 'pending')
                                        <form action="{{ route('admin.recruiters.activate', $recruiter->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check mr-1"></i> Activer
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.recruiters.destroy', $recruiter->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce compte ? Cette action est irréversible.')">
                                            <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="text-lg font-medium mb-2">Aucun recruteur trouvé</h3>
                <p class="mb-4">Aucun recruteur ne correspond à vos critères de recherche.</p>
            </div>
        @endif
    </div>
    
    <!-- Pagination -->
    @if(count($recruiters) > 0)
        <div class="mt-4">
            {{ $recruiters->links() }}
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Handle search
    document.getElementById('search-button').addEventListener('click', function() {
        const searchValue = document.getElementById('search-input').value;
        const statusValue = document.getElementById('status-filter').value;
        
        let url = '{{ route("admin.recruiters.index") }}?';
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
        
        let url = '{{ route("admin.recruiters.index") }}?';
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
            
            let url = '{{ route("admin.recruiters.index") }}?sort=' + sort + '&direction=' + direction;
            
            if (searchValue) {
                url += '&search=' + encodeURIComponent(searchValue);
            }
            
            if (statusValue) {
                url += '&status=' + encodeURIComponent(statusValue);
            }
            
            window.location.href = url;
        });
    });
</script>
@endsection

