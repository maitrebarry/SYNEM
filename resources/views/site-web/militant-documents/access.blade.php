@extends('layouts.site')

@section('title', 'Espace Militant – Connexion')

@section('styles')
<style>
.portal-login-wrap {
    min-height: 100vh;
    background: linear-gradient(135deg, #0f0f1a 0%, #1A1A2E 60%, #16213e 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 16px;
}
.portal-login-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    width: 100%;
    max-width: 440px;
    box-shadow: 0 24px 80px rgba(0,0,0,.45);
}
.portal-login-top {
    background: linear-gradient(135deg, #C8102E 0%, #a00d25 100%);
    padding: 36px 32px 28px;
    text-align: center;
    position: relative;
}
.portal-login-top::after {
    content: '';
    position: absolute;
    bottom: -1px; left: 0; right: 0;
    height: 32px;
    background: #fff;
    border-radius: 32px 32px 0 0;
}
.portal-logo-circle {
    width: 72px; height: 72px;
    background: rgba(255,255,255,.15);
    border: 3px solid rgba(255,255,255,.4);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    font-size: 1.9rem;
}
.portal-login-top h3 {
    color: #fff;
    font-family: 'Montserrat', sans-serif;
    font-weight: 800;
    font-size: 1.3rem;
    margin: 0 0 4px;
}
.portal-login-top p {
    color: rgba(255,255,255,.8);
    font-size: .82rem;
    margin: 0;
}
.portal-login-body {
    padding: 28px 32px 36px;
}
.portal-field-label {
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    font-size: .8rem;
    color: #374151;
    margin-bottom: 6px;
    display: block;
}
.portal-field {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: .9rem;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
}
.portal-field:focus {
    border-color: #C8102E;
    box-shadow: 0 0 0 3px rgba(200,16,46,.12);
}
.portal-field-icon-wrap {
    position: relative;
}
.portal-field-icon-wrap .portal-field {
    padding-left: 44px;
}
.portal-field-icon-wrap .fi {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 1rem;
}
.portal-btn-login {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #C8102E 0%, #a00d25 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: .95rem;
    cursor: pointer;
    transition: transform .15s, box-shadow .15s;
}
.portal-btn-login:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(200,16,46,.4);
}
.portal-flag {
    display: flex;
    height: 4px;
    margin-bottom: 20px;
    border-radius: 4px;
    overflow: hidden;
}
.portal-flag span { flex: 1; }
.portal-info-box {
    background: #f8fafc;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 14px 16px;
    font-size: .8rem;
    color: #6b7280;
}
.portal-info-box strong { color: #374151; }
</style>
@endsection

@section('content')
<div class="portal-login-wrap">
    <div class="portal-login-card">

        {{-- En-tête rouge --}}
        <div class="portal-login-top">
            <div class="portal-logo-circle">🪪</div>
            <h3>Espace Militant SYNEM</h3>
            <p>Connectez-vous pour accéder à vos documents et échanger avec les responsables</p>
        </div>

        {{-- Corps --}}
        <div class="portal-login-body">

            {{-- Bande tricolore Mali --}}
            <div class="portal-flag mb-4">
                <span style="background:#0b8f3c;"></span>
                <span style="background:#f2c94c;"></span>
                <span style="background:#d62828;"></span>
            </div>

            @if($errors->any())
                <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:10px;padding:12px 16px;margin-bottom:20px;font-size:.85rem;color:#991b1b;">
                    <strong>Accès refusé :</strong>
                    @foreach($errors->all() as $err)
                        <div>{{ $err }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('militant.documents.verify') }}" method="POST">
                @csrf

                <div style="margin-bottom:18px;">
                    <label class="portal-field-label">Adresse email</label>
                    <div class="portal-field-icon-wrap">
                        <i class="fi fas fa-envelope"></i>
                        <input class="portal-field" type="email" name="email" required
                            value="{{ old('email') }}"
                            placeholder="votre.email@exemple.com"
                            autocomplete="email">
                    </div>
                </div>

                <div style="margin-bottom:24px;">
                    <label class="portal-field-label">Numéro de carte de membre</label>
                    <div class="portal-field-icon-wrap">
                        <i class="fi fas fa-id-card"></i>
                        <input class="portal-field" type="text" name="card_number" required
                            value="{{ old('card_number') }}"
                            placeholder="Ex : 0205"
                            autocomplete="off">
                    </div>
                </div>

                <button type="submit" class="portal-btn-login">
                    <i class="fas fa-sign-in-alt" style="margin-right:8px;"></i>Accéder à mon espace
                </button>
            </form>

            <div class="portal-info-box mt-4">
                <i class="fas fa-shield-alt" style="color:#C8102E;margin-right:6px;"></i>
                <strong>Accès sécurisé.</strong> Seuls les militants dont le dossier est <strong>approuvé</strong> par la direction peuvent se connecter.
                En cas de problème, contactez votre section régionale.
            </div>
        </div>
    </div>
</div>
@endsection
