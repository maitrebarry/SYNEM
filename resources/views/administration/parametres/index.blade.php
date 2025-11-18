@extends('layouts.administration')


@section('title', 'Paramètres du Site - SYNEM')

@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('administration.tableau-de-bord') }}">Tableau de bord</a></li>
        <li class="breadcrumb-item active" aria-current="page">Paramètres</li>
    </ol>
</nav>
@endsection

@section('styles')
<style>
    .parametres-sidebar {
        background: #f8f9fa;
        border-right: 1px solid #dee2e6;
        min-height: calc(100vh - 200px);
    }
    
    .parametres-menu .nav-link {
        color: #495057;
        padding: 12px 20px;
        border-radius: 0;
        border-left: 3px solid transparent;
        transition: all 0.3s ease;
    }
    
    .parametres-menu .nav-link:hover {
        background-color: #e9ecef;
        color: #007bff;
    }
    
    .parametres-menu .nav-link.active {
        background-color: #e3f2fd;
        color: #007bff;
        border-left-color: #007bff;
        font-weight: 600;
    }
    
    .parametres-content {
        background: white;
        padding: 30px;
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    
    .setting-card {
        border: 1px solid #e3e6f0;
        border-radius: 0.35rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
    }
    
    .setting-card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        padding: 1rem 1.25rem;
    }
    
    .setting-card-body {
        padding: 1.25rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #5a5c69;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <h4 class="mb-0 text-synem-primary">Paramètres du Site</h4>
                <div>
                    <button class="btn btn-success" id="saveSettings">
                        <i class="bi bi-save me-1"></i> Enregistrer les modifications
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar des paramètres - col-3 -->
        <div class="col-lg-3 col-md-4">
            <div class="parametres-sidebar rounded">
                <div class="parametres-menu">
                    <nav class="nav flex-column">
                        <a class="nav-link {{ $section_active == 'generaux' ? 'active' : '' }}" 
                           href="{{ route('administration.parametres.generaux') }}">
                            <i class="bi bi-gear me-2"></i> Paramètres Généraux
                        </a>
                        <a class="nav-link {{ $section_active == 'seo' ? 'active' : '' }}" 
                           href="{{ route('administration.parametres.seo') }}">
                            <i class="bi bi-search me-2"></i> SEO & Référencement
                        </a>
                        <a class="nav-link {{ $section_active == 'utilisateurs' ? 'active' : '' }}" 
                           href="{{ route('administration.parametres.utilisateurs') }}">
                            <i class="bi bi-people me-2"></i> Utilisateurs Admin
                        </a>
                        <a class="nav-link {{ $section_active == 'reseaux-sociaux' ? 'active' : '' }}" 
                           href="{{ route('administration.parametres.reseaux-sociaux') }}">
                            <i class="bi bi-share me-2"></i> Réseaux Sociaux
                        </a>
                        <a class="nav-link {{ $section_active == 'notifications' ? 'active' : '' }}" 
                           href="{{ route('administration.parametres.notifications') }}">
                            <i class="bi bi-bell me-2"></i> Notifications
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Contenu des paramètres - col-9 -->
        <div class="col-lg-9 col-md-8">
            <div class="parametres-content">
                @include($contenu)
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Gestion de l'enregistrement des paramètres
        $('#saveSettings').on('click', function() {
            const btn = $(this);
            const originalText = btn.html();
            
            btn.prop('disabled', true).html('<i class="bi bi-arrow-repeat spinner-border spinner-border-sm me-1"></i> Enregistrement...');
            
            // Simulation d'enregistrement
            setTimeout(function() {
                btn.prop('disabled', false).html(originalText);
                showNotification('success', 'Paramètres enregistrés avec succès !');
            }, 1500);
        });
        
        // Fonction de notification
        function showNotification(type, message) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alert = $('<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">' +
                '<i class="bi bi-check-circle me-2"></i>' + message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                '</div>');
            
            $('.parametres-content').prepend(alert);
            
            setTimeout(function() {
                alert.alert('close');
            }, 5000);
        }
        
        // Gestion des switches
        $('.form-check-input').on('change', function() {
            const isChecked = $(this).is(':checked');
            const label = $(this).next('.form-check-label');
            
            if (isChecked) {
                label.addClass('text-success');
            } else {
                label.removeClass('text-success');
            }
        });
    });
</script>
@endsection