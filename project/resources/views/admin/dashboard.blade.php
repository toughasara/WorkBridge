@extends('layouts.admin')

@section('title', 'Tableau de bord administrateur')

@section('header-title', 'Tableau de bord')

@section('styles')
<style>
    .stats-card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .stats-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    
    .stats-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }
    
    .stats-label {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }
    
    .chart-container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-top: 2rem;
    }
    
    .chart-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
    }
    
    .recent-activity {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-top: 2rem;
    }
    
    .activity-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
    }
    
    .activity-item {
        padding: 1rem 0;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-message {
        font-weight: 500;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }
    
    .activity-time {
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-blue {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .badge-green {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .badge-yellow {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .badge-red {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .badge-purple {
        background-color: #ede9fe;
        color: #5b21b6;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
        <!-- Total Users -->
        <div class="stats-card">
            <div class="stats-icon bg-blue-100 text-blue-600">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-value">{{ $totalUsers }}</div>
            <div class="stats-label">Utilisateurs totaux</div>
        </div>
        
        <!-- Total Recruiters -->
        <div class="stats-card">
            <div class="stats-icon bg-green-100 text-green-600">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stats-value">{{ $totalRecruiters }}</div>
            <div class="stats-label">Recruteurs</div>
        </div>
        
        <!-- Total Candidates -->
        <div class="stats-card">
            <div class="stats-icon bg-purple-100 text-purple-600">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stats-value">{{ $totalCandidates }}</div>
            <div class="stats-label">Candidats</div>
        </div>
        
        <!-- Total Jobs -->
        <div class="stats-card">
            <div class="stats-icon bg-yellow-100 text-yellow-600">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stats-value">{{ $totalJobs }}</div>
            <div class="stats-label">Offres d'emploi</div>
        </div>
        
        <!-- Pending Jobs -->
        <div class="stats-card">
            <div class="stats-icon bg-red-100 text-red-600">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-value">{{ $pendingJobs }}</div>
            <div class="stats-label">Offres en attente</div>
            @if($pendingJobs > 0)
                <a href="{{ route('admin.jobs.approval') }}" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">
                    Voir les offres en attente →
                </a>
            @endif
        </div>
    </div>
    
    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        <!-- User Registration Chart -->
        <div class="chart-container">
            <h3 class="chart-title">Inscriptions mensuelles</h3>
            <canvas id="registrationChart" height="300"></canvas>
        </div>
        
        <!-- Job Postings Chart -->
        <div class="chart-container">
            <h3 class="chart-title">Offres d'emploi publiées</h3>
            <canvas id="jobsChart" height="300"></canvas>
        </div>
    </div>
    
    <!-- Recent Activity -->
    
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection

