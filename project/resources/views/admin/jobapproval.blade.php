@extends('layouts.admin')

@section('title', 'Approbation des offres d\'emploi')

@section('header-title', 'Approbation des offres d\'emploi')

@section('styles')
<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .table-container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }
    
    .jobs-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .jobs-table th {
        background-color: #f9fafb;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 500;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .jobs-table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
    }
    
    .jobs-table tr:last-child td {
        border-bottom: none;
    }
    
    .jobs-table tr:hover {
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
    
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-yellow {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .btn-approve {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #10B981;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
        margin-right: 0.5rem;
    }
    
    .btn-approve:hover {
        background-color: #059669;
    }
    
    .btn-reject {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #EF4444;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-reject:hover {
        background-color: #DC2626;
    }
    
    .btn-view {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: background-color 0.2s;
        cursor: pointer;
        border: 1px solid #d1d5db;
        margin-right: 0.5rem;
    }
    
    .btn-view:hover {
        background-color: #e5e7eb;
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
    
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 100;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }
    
    .modal-content {
        background-color: white;
        margin: 10% auto;
        padding: 1.5rem;
        border-radius: 0.5rem;
        max-width: 500px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
    }
    
    .modal-close {
        font-size: 1.5rem;
        font-weight: 700;
        color: #9ca3af;
        cursor: pointer;
    }
    
    .modal-close:hover {
        color: #1f2937;
    }
    
    .modal-body {
        margin-bottom: 1.5rem;
    }
    
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
    }
    
    .form-textarea {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        resize: vertical;
    }
    
    .form-textarea:focus {
        border-color: #4f46e5;
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .pagination-container {
        margin-top: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="header-container">
        <h1 class="text-2xl font-bold text-gray-900">Offres d'emploi en attente d'approbation</h1>
    </div>
    
    <!-- Table -->
    <div class="table-container">
        @if(count($pendingJobs) > 0)
            <table class="jobs-table">
                <thead>
                    <tr>
                        <th class="sortable" data-sort="title">Intitulé du poste</th>
                        <th>Entreprise</th>
                        <th class="sortable" data-sort="created_at">Date de soumission</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingJobs as $job)
                        <tr>
                            <td>
                                <div class="font-medium">{{ $job->title }}</div>
                                <div class="text-sm text-gray-500">{{ $job->location }}</div>
                            </td>
                            <td>
                                <div class="font-medium">{{ $job->user->company->name ?? 'Entreprise non spécifiée' }}</div>
                                <div class="text-sm text-gray-500">{{ $job->user->name ?? 'Utilisateur inconnu'}}</div>
                            </td>
                            <td>
                                {{ $job->created_at->format('d/m/Y H:i') }}
                                <div class="text-sm text-gray-500">{{ $job->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <span class="badge badge-yellow">En attente</span>
                            </td>
                            <td>
                                <div class="flex">
                                    <a href="{{ route('admin.JobApproval', $job->id) }}" class="btn-view">
                                        <i class="fas fa-eye mr-2"></i> Voir
                                    </a>
                                    <form action="{{ route('admin.JobApproval.approve', $job->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-approve">
                                            <i class="fas fa-check mr-2"></i> Approuver
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.JobApproval.reject', $job->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-reject">
                                            <i class="fas fa-times  mr-2"></i> Rejeter
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
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="text-lg font-medium mb-2">Aucune offre en attente</h3>
                <p>Toutes les offres d'emploi ont été traitées.</p>
            </div>
        @endif
    </div>
    
    <!-- Pagination -->
    @if(count($pendingJobs) > 0)
        <div class="pagination-container">
            {{ $pendingJobs->links() }}
        </div>
    @endif
    
    <!-- Approve Modal -->
    <div id="approve-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Approuver l'offre d'emploi</h2>
                <span class="modal-close" onclick="closeModal('approve-modal')">&times;</span>
            </div>
            <form id="approve-form" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir approuver cette offre d'emploi ? Elle sera publiée et visible par tous les candidats.</p>
                    
                    <div class="form-group mt-4">
                        <label for="approve-comment" class="form-label">Commentaire (optionnel)</label>
                        <textarea id="approve-comment" name="comment" class="form-textarea" rows="3" placeholder="Ajouter un commentaire pour le recruteur..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-view" onclick="closeModal('approve-modal')">Annuler</button>
                    <button type="submit" class="btn-approve">Approuver</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Reject Modal -->
    <div id="reject-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Rejeter l'offre d'emploi</h2>
                <span class="modal-close" onclick="closeModal('reject-modal')">&times;</span>
            </div>
            <form id="reject-form" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir rejeter cette offre d'emploi ? Elle ne sera pas publiée.</p>
                    
                    <div class="form-group mt-4">
                        <label for="reject-reason" class="form-label">Motif du rejet <span class="text-red-500">*</span></label>
                        <textarea id="reject-reason" name="reason" class="form-textarea" rows="3" placeholder="Expliquez pourquoi cette offre est rejetée..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-view" onclick="closeModal('reject-modal')">Annuler</button>
                    <button type="submit" class="btn-reject">Rejeter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


