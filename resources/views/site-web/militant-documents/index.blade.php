@extends('layouts.site')

@section('title', 'Mon Espace – ' . $militant->name)

@section('styles')
<style>
/* ═══ RESET GLOBAL PORTAL ══════════════════════════════════ */
.portal-wrap { background: #f1f4f9; min-height: 100vh; padding-top: 70px; }

/* ═══ HEADER MILITANT ══════════════════════════════════════ */
.portal-header {
    background: linear-gradient(135deg, #0f0f1a 0%, #1A1A2E 100%);
    padding: 20px 0 0;
    border-bottom: 3px solid #C8102E;
    position: sticky;
    top: 70px;
    z-index: 100;
}
.portal-header-inner {
    max-width: 1140px;
    margin: 0 auto;
    padding: 0 24px;
}
.portal-avatar {
    width: 48px; height: 48px;
    background: linear-gradient(135deg, #C8102E, #a00d25);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Montserrat', sans-serif;
    font-weight: 800;
    font-size: 1.1rem;
    color: #fff;
    flex-shrink: 0;
    border: 2px solid rgba(255,255,255,.2);
}
.portal-name {
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: 1rem;
    color: #fff;
    line-height: 1.2;
}
.portal-meta {
    font-size: .72rem;
    color: rgba(255,255,255,.55);
}
.portal-logout {
    background: rgba(200,16,46,.15);
    border: 1px solid rgba(200,16,46,.4);
    color: #fca5a5;
    border-radius: 8px;
    padding: 6px 14px;
    font-size: .8rem;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s;
}
.portal-logout:hover { background: rgba(200,16,46,.3); color: #fff; }

/* ═══ ONGLETS NAVIGATION ═══════════════════════════════════ */
.portal-tabs {
    display: flex;
    gap: 4px;
    margin-top: 16px;
}
.portal-tab {
    padding: 10px 22px 12px;
    color: rgba(255,255,255,.5);
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    font-size: .82rem;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: color .2s, border-color .2s;
    display: flex;
    align-items: center;
    gap: 7px;
    white-space: nowrap;
}
.portal-tab:hover { color: rgba(255,255,255,.85); }
.portal-tab.active { color: #fff; border-bottom-color: #C8102E; }
.portal-tab .tab-badge {
    background: #C8102E;
    color: #fff;
    border-radius: 20px;
    padding: 1px 7px;
    font-size: .65rem;
    font-weight: 700;
}

/* ═══ CONTENU ONGLETS ══════════════════════════════════════ */
.portal-content {
    max-width: 1140px;
    margin: 0 auto;
    padding: 28px 24px;
}
.portal-pane { display: none; }
.portal-pane.active { display: block; }

/* ═══ BARRE DE RECHERCHE & FILTRES ═════════════════════════ */
.search-bar-wrap {
    position: relative;
    margin-bottom: 20px;
}
.search-bar-wrap .search-icon {
    position: absolute;
    left: 16px; top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
}
.search-bar {
    width: 100%;
    padding: 12px 16px 12px 44px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: .9rem;
    background: #fff;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}
.search-bar:focus { border-color: #C8102E; box-shadow: 0 0 0 3px rgba(200,16,46,.1); }

.filter-pills { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 24px; }
.filter-pill {
    padding: 5px 14px;
    border-radius: 20px;
    border: 1.5px solid #d1d5db;
    background: #fff;
    color: #374151;
    font-size: .78rem;
    font-weight: 600;
    cursor: pointer;
    transition: all .15s;
    user-select: none;
}
.filter-pill:hover { border-color: #C8102E; color: #C8102E; }
.filter-pill.active { background: #C8102E; border-color: #C8102E; color: #fff; }

/* ═══ CARTES DOCUMENTS ══════════════════════════════════════ */
.doc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px,1fr)); gap: 18px; }

.doc-card {
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,.07);
    transition: transform .2s, box-shadow .2s;
    display: flex;
    flex-direction: column;
}
.doc-card:hover { transform: translateY(-4px); box-shadow: 0 8px 30px rgba(0,0,0,.12); }

.doc-card-top {
    padding: 20px 20px 14px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.doc-type-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.doc-type-pdf   { background: #fef2f2; }
.doc-type-word  { background: #eff6ff; }
.doc-type-excel { background: #f0fdf4; }
.doc-type-other { background: #f5f3ff; }

.doc-title {
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: .9rem;
    color: #111827;
    line-height: 1.3;
    margin-bottom: 4px;
}
.doc-desc {
    font-size: .78rem;
    color: #6b7280;
    line-height: 1.5;
}
.doc-card-footer {
    margin-top: auto;
    padding: 12px 20px 16px;
    border-top: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}
.doc-meta-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: .7rem;
    font-weight: 700;
}
.doc-meta-pdf   { background: #fef2f2; color: #dc2626; }
.doc-meta-word  { background: #eff6ff; color: #2563eb; }
.doc-meta-excel { background: #f0fdf4; color: #16a34a; }
.doc-meta-other { background: #f5f3ff; color: #7c3aed; }

.doc-download-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    background: #C8102E;
    color: #fff;
    border-radius: 8px;
    font-size: .78rem;
    font-weight: 700;
    text-decoration: none;
    transition: background .15s, transform .15s;
    white-space: nowrap;
}
.doc-download-btn:hover { background: #a00d25; color: #fff; transform: scale(1.03); text-decoration: none; }

/* ═══ CHAT / MESSAGERIE ════════════════════════════════════ */
.chat-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}
@media (min-width: 768px) {
    .chat-layout { grid-template-columns: 1fr 360px; }
}

.chat-box {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,.07);
    display: flex;
    flex-direction: column;
    min-height: 520px;
}
.chat-box-header {
    padding: 18px 20px;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    gap: 12px;
}
.chat-admin-avatar {
    width: 40px; height: 40px;
    background: linear-gradient(135deg, #1A1A2E, #0f0f1a);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}
.chat-feed {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 18px;
    max-height: 380px;
}
.chat-entry-wrap { display: flex; flex-direction: column; gap: 8px; }

/* Message militant (droite) */
.chat-msg-militant {
    align-self: flex-end;
    max-width: 78%;
}
.chat-msg-militant .bubble {
    background: #C8102E;
    color: #fff;
    border-radius: 16px 4px 16px 16px;
    padding: 12px 16px;
    font-size: .85rem;
    line-height: 1.6;
}
.chat-msg-militant .bubble-meta {
    text-align: right;
    font-size: .7rem;
    color: #9ca3af;
    margin-top: 4px;
    padding-right: 4px;
}

/* Réponse admin (gauche) */
.chat-msg-admin {
    align-self: flex-start;
    max-width: 78%;
}
.chat-msg-admin .bubble {
    background: #1A1A2E;
    color: #e2e8f0;
    border-radius: 4px 16px 16px 16px;
    padding: 12px 16px;
    font-size: .85rem;
    line-height: 1.6;
}
.chat-msg-admin .bubble-meta {
    font-size: .7rem;
    color: #9ca3af;
    margin-top: 4px;
    padding-left: 4px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.chat-msg-admin .bubble-meta .admin-tag {
    background: #f1f4f9;
    color: #374151;
    border-radius: 10px;
    padding: 1px 8px;
    font-weight: 700;
    font-size: .66rem;
}

/* Statut en attente */
.chat-pending-notice {
    align-self: flex-end;
    font-size: .72rem;
    color: #f59e0b;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Zone de saisie */
.chat-input-area {
    padding: 16px 20px;
    border-top: 1px solid #f3f4f6;
}
.chat-input-row {
    display: flex;
    gap: 10px;
    align-items: flex-end;
}
.chat-textarea {
    flex: 1;
    padding: 10px 14px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: .85rem;
    resize: none;
    outline: none;
    transition: border-color .2s;
    min-height: 44px;
    max-height: 120px;
}
.chat-textarea:focus { border-color: #C8102E; }
.chat-send-btn {
    width: 44px; height: 44px;
    background: #C8102E;
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    cursor: pointer;
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    transition: background .15s, transform .1s;
}
.chat-send-btn:hover { background: #a00d25; transform: scale(1.05); }
.chat-send-btn:disabled { background: #d1d5db; cursor: not-allowed; transform: none; }

/* Sidebar infos chat */
.chat-sidebar {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.chat-info-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,.07);
}
.chat-info-card h6 {
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: .82rem;
    color: #111827;
    margin-bottom: 14px;
}
.chat-stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f3f4f6;
    font-size: .8rem;
}
.chat-stat-row:last-child { border-bottom: none; }
.chat-stat-val { font-weight: 700; }

/* ═══ CARTE DE MEMBRE ══════════════════════════════════════ */
.card-section-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}
@media (min-width: 768px) {
    .card-section-grid { grid-template-columns: 1fr 1fr; }
}

.carte-status-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,.07);
}
.carte-status-header {
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.carte-status-body { padding: 0 20px 20px; }
.status-badge-big {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: .8rem;
    font-weight: 700;
}
.status-pending  { background: #fff3cd; color: #92400e; }
.status-approved { background: #d1fae5; color: #065f46; }
.status-revision { background: #fee2e2; color: #991b1b; }

/* Caméra */
.camera-shell {
    background: #0f172a;
    border-radius: 14px;
    overflow: hidden;
    position: relative;
    aspect-ratio: 4/3;
    max-height: 260px;
}
.camera-shell video,
.camera-shell canvas {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}
.camera-overlay {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    text-align: center; color: #e2e8f0; padding: 1rem;
    background: rgba(2,6,23,.55);
}
.camera-btn-row { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 12px; }
.portal-btn {
    padding: 9px 18px;
    border-radius: 10px;
    font-size: .82rem;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: all .15s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.portal-btn-primary { background: #C8102E; color: #fff; }
.portal-btn-primary:hover { background: #a00d25; }
.portal-btn-success { background: #16a34a; color: #fff; }
.portal-btn-success:hover { background: #15803d; }
.portal-btn-outline { background: transparent; border: 2px solid #d1d5db; color: #374151; }
.portal-btn-outline:hover { border-color: #9ca3af; }

/* Upload zone */
.upload-zone {
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s;
    position: relative;
}
.upload-zone:hover { border-color: #C8102E; background: #fff5f5; }
.upload-zone input { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
.upload-zone .uzi { font-size: 2rem; margin-bottom: 8px; }

/* Empty / message vide */
.empty-state {
    text-align: center;
    padding: 48px 24px;
    color: #9ca3af;
}
.empty-state .es-icon { font-size: 3.5rem; margin-bottom: 12px; }
.empty-state p { font-size: .88rem; line-height: 1.6; margin: 0; }

/* ═══ ALERT FEEDBACK ═══════════════════════════════════════ */
.portal-alert {
    border-radius: 10px;
    padding: 12px 16px;
    font-size: .84rem;
    margin-bottom: 14px;
}
.portal-alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.portal-alert-danger  { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

/* ═══ RESPONSIVE ════════════════════════════════════════════ */
@media (max-width: 640px) {
    .portal-tab { padding: 8px 12px 10px; font-size: .73rem; }
    .portal-name { font-size: .88rem; }
}
</style>
@endsection

@section('content')
@php
    $initials = strtoupper(substr($militant->prenom ?? $militant->name, 0, 1) . substr($militant->nom ?? '', 0, 1));
    $pendingMsgs = $messages->where('status', 'pending')->count();
    $answeredMsgs = $messages->where('status', 'answered')->count();
    $totalDocs = count($documents);
@endphp

<div class="portal-wrap">

{{-- ═══ EN-TÊTE STICKY ════════════════════════════════════ --}}
<div class="portal-header">
    <div class="portal-header-inner">
        <div style="display:flex;align-items:center;gap:14px;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="portal-avatar">{{ $initials ?: '?' }}</div>
                <div>
                    <div class="portal-name">{{ $militant->name }}</div>
                    <div class="portal-meta">
                        <i class="fas fa-envelope" style="margin-right:4px;"></i>{{ $militant->email }}
                        &nbsp;·&nbsp;
                        <i class="fas fa-id-card" style="margin-right:4px;"></i>Carte N° {{ $militant->n_cartes_syndicale ?: '—' }}
                    </div>
                </div>
            </div>
            <form action="{{ route('militant.documents.logout') }}" method="POST">
                @csrf
                <button type="submit" class="portal-logout">
                    <i class="fas fa-sign-out-alt" style="margin-right:5px;"></i>Déconnexion
                </button>
            </form>
        </div>

        {{-- Onglets --}}
        <div class="portal-tabs">
            <div class="portal-tab active" data-target="pane-docs">
                <i class="fas fa-folder-open"></i>
                Mes Documents
                @if($totalDocs > 0)
                    <span class="tab-badge">{{ $totalDocs }}</span>
                @endif
            </div>
            <div class="portal-tab" data-target="pane-chat">
                <i class="fas fa-comments"></i>
                Mes Échanges
                @if($pendingMsgs > 0)
                    <span class="tab-badge">{{ $pendingMsgs }}</span>
                @endif
            </div>
            @if($activeMemberCardCampaign)
            <div class="portal-tab" data-target="pane-carte">
                <i class="fas fa-id-card"></i>
                Ma Carte SYNEM
                @if(!$memberCardSubmission || $memberCardSubmission->status === 'revision_requested')
                    <span class="tab-badge">!</span>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ═══ CONTENU DES ONGLETS ═══════════════════════════════ --}}
<div class="portal-content">

    {{-- ── ONGLET 1 : DOCUMENTS ─────────────────────────── --}}
    <div class="portal-pane active" id="pane-docs">

        {{-- Recherche --}}
        <div class="search-bar-wrap">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-bar" id="docSearch" placeholder="Rechercher un document par titre, description ou type...">
        </div>

        {{-- Filtres --}}
        <div class="filter-pills">
            <span class="filter-pill active" data-filter="all" data-group="type">📂 Tous ({{ $totalDocs }})</span>
            <span class="filter-pill" data-filter="pdf"   data-group="type">📄 PDF ({{ collect($documents)->where('type','PDF')->count() }})</span>
            <span class="filter-pill" data-filter="word"  data-group="type">📝 Word ({{ collect($documents)->where('type','WORD')->count() }})</span>
            <span class="filter-pill" data-filter="excel" data-group="type">📊 Excel ({{ collect($documents)->where('type','EXCEL')->count() }})</span>
            <span class="filter-pill" data-filter="administratif" data-group="cat">🏛 Administratif</span>
            <span class="filter-pill" data-filter="formation"     data-group="cat">🎓 Formation</span>
            <span class="filter-pill" data-filter="activite"      data-group="cat">📈 Activité</span>
        </div>

        {{-- Grille documents --}}
        <div class="doc-grid" id="docGrid">
            @forelse($documents as $doc)
                @php
                    $typeKey = strtolower($doc['type'] ?? 'other');
                    $icons   = ['pdf'=>'📄','word'=>'📝','excel'=>'📊'];
                    $icon    = $icons[$typeKey] ?? '📁';
                    $cat     = strtolower($doc['category'] ?? 'divers');
                @endphp
                <div class="doc-card" data-type="{{ $typeKey }}" data-cat="{{ $cat }}" data-title="{{ strtolower($doc['title'] ?? '') }}" data-desc="{{ strtolower($doc['description'] ?? '') }}">
                    <div class="doc-card-top">
                        <div class="doc-type-icon doc-type-{{ $typeKey }}">{{ $icon }}</div>
                        <div style="flex:1;min-width:0;">
                            <div class="doc-title">{{ $doc['title'] ?? '' }}</div>
                            <div class="doc-desc">{{ Str::limit($doc['description'] ?? '', 90) }}</div>
                        </div>
                    </div>
                    <div class="doc-card-footer">
                        <div style="display:flex;flex-direction:column;gap:4px;">
                            <span class="doc-meta-pill doc-meta-{{ $typeKey }}">
                                {{ strtoupper($typeKey) }}
                            </span>
                            @if(!empty($doc['size']))
                                <span style="font-size:.7rem;color:#9ca3af;">{{ $doc['size'] }}</span>
                            @endif
                        </div>
                        <a href="{{ route('militant.documents.download', $doc['filename']) }}"
                           class="doc-download-btn" target="_blank">
                            <i class="fas fa-download"></i>Télécharger
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column:1/-1;">
                    <div class="empty-state">
                        <div class="es-icon">📭</div>
                        <p>Aucun document disponible pour le moment.<br>
                        Les documents réservés aux militants seront ajoutés prochainement par les responsables.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Message "aucun résultat" --}}
        <div id="docEmpty" style="display:none;">
            <div class="empty-state">
                <div class="es-icon">🔍</div>
                <p>Aucun document ne correspond à votre recherche.<br>Essayez un autre mot-clé ou réinitialisez les filtres.</p>
            </div>
        </div>
    </div>

    {{-- ── ONGLET 2 : ÉCHANGES ──────────────────────────── --}}
    <div class="portal-pane" id="pane-chat">
        <div class="chat-layout">

            {{-- Boîte de discussion --}}
            <div class="chat-box">
                <div class="chat-box-header">
                    <div class="chat-admin-avatar">🛡️</div>
                    <div>
                        <div style="font-family:'Montserrat',sans-serif;font-weight:700;font-size:.9rem;color:#111827;">Responsables SYNEM</div>
                        <div style="font-size:.72rem;color:#6b7280;">Posez vos questions – réponse sous 24 à 48h</div>
                    </div>
                </div>

                {{-- Feedback --}}
                <div id="chatFeedback" style="margin:0 20px;margin-top:12px;display:none;" class="portal-alert"></div>

                {{-- Fil de discussion --}}
                <div class="chat-feed" id="militantChatList">
                    @forelse($messages as $msg)
                        <div class="chat-entry-wrap" data-status="{{ $msg->status }}">
                            {{-- Message du militant --}}
                            <div class="chat-msg-militant">
                                <div class="bubble">{!! nl2br(e($msg->question)) !!}</div>
                                <div class="bubble-meta">
                                    Vous · {{ $msg->created_at->format('d/m/Y à H:i') }}
                                    &nbsp;·&nbsp;
                                    @if($msg->status === 'answered')
                                        <span style="color:#10b981;">✓ Répondu</span>
                                    @else
                                        <span style="color:#f59e0b;">⏳ En attente</span>
                                    @endif
                                </div>
                            </div>
                            {{-- Réponse admin --}}
                            @if($msg->answer)
                                <div class="chat-msg-admin">
                                    <div class="bubble">{!! nl2br(e($msg->answer)) !!}</div>
                                    <div class="bubble-meta">
                                        <span class="admin-tag">Admin SYNEM</span>
                                        {{ $msg->updated_at->format('d/m/Y à H:i') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="empty-state" style="flex:1;justify-content:center;display:flex;flex-direction:column;align-items:center;">
                            <div class="es-icon">💬</div>
                            <p>Aucun échange pour le moment.<br>Posez votre première question ci-dessous !</p>
                        </div>
                    @endforelse
                </div>

                {{-- Zone de saisie --}}
                <div class="chat-input-area">
                    <form id="militantChatForm">
                        @csrf
                        <div class="chat-input-row">
                            <textarea class="chat-textarea" id="questionInput" name="question" rows="1"
                                placeholder="Écrivez votre question ou message..." required></textarea>
                            <button type="submit" class="chat-send-btn" id="submitQuestionBtn" title="Envoyer">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <div style="font-size:.7rem;color:#9ca3af;margin-top:6px;text-align:right;">
                            Appuyez sur Entrée + Maj pour aller à la ligne
                        </div>
                    </form>
                </div>
            </div>

            {{-- Sidebar infos --}}
            <div class="chat-sidebar">
                <div class="chat-info-card">
                    <h6>📊 Résumé de mes échanges</h6>
                    <div class="chat-stat-row">
                        <span>Total de messages</span>
                        <span class="chat-stat-val">{{ $messages->count() }}</span>
                    </div>
                    <div class="chat-stat-row">
                        <span>Questions sans réponse</span>
                        <span class="chat-stat-val" style="color:#f59e0b;" id="pendingChatBadge">{{ $pendingMsgs }}</span>
                    </div>
                    <div class="chat-stat-row">
                        <span>Questions répondues</span>
                        <span class="chat-stat-val" style="color:#10b981;">{{ $answeredMsgs }}</span>
                    </div>
                </div>
                <div class="chat-info-card">
                    <h6>ℹ️ Comment ça marche ?</h6>
                    <div style="font-size:.78rem;color:#6b7280;line-height:1.7;">
                        <p style="margin:0 0 8px;">1️⃣ Rédigez votre question dans le champ à gauche et envoyez.</p>
                        <p style="margin:0 0 8px;">2️⃣ Les responsables SYNEM liront votre message et vous répondront.</p>
                        <p style="margin:0;">3️⃣ Revenez ici pour voir les réponses. Une notification vous sera envoyée par email.</p>
                    </div>
                </div>
                <div class="chat-info-card" style="background:#fff8f0;border:1px solid #fed7aa;">
                    <h6 style="color:#92400e;">📞 Contact direct</h6>
                    <div style="font-size:.78rem;color:#92400e;line-height:1.7;">
                        Pour les urgences, contactez votre section régionale ou l'administration centrale.<br>
                        <strong>Email :</strong> <a href="mailto:contact@synem.ml" style="color:#C8102E;">contact@synem.ml</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── ONGLET 3 : MA CARTE ──────────────────────────── --}}
    @if($activeMemberCardCampaign)
    <div class="portal-pane" id="pane-carte">
        <div class="card-section-grid">

            {{-- Statut de ma photo --}}
            <div class="carte-status-card">
                <div class="carte-status-header" style="background:linear-gradient(135deg,#1A1A2E,#0f0f1a);">
                    <div style="font-size:1.5rem;">🪪</div>
                    <div>
                        <div style="font-family:'Montserrat',sans-serif;font-weight:700;color:#fff;font-size:.95rem;">Confection de ma carte SYNEM</div>
                        <div style="font-size:.72rem;color:rgba(255,255,255,.5);">{{ optional($activeMemberCardCampaign->sent_at)->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div class="carte-status-body" style="padding-top:16px;">
                    <p style="font-size:.84rem;color:#374151;line-height:1.7;margin-bottom:16px;">{{ $activeMemberCardCampaign->message }}</p>

                    @if($memberCardSubmission)
                        @php
                            $sClass = ['pending'=>'status-pending','approved'=>'status-approved','revision_requested'=>'status-revision'][$memberCardSubmission->status] ?? 'status-pending';
                            $sLabel = ['pending'=>'⏳ En attente de validation','approved'=>'✅ Photo validée','revision_requested'=>'🔄 Nouvelle photo demandée'][$memberCardSubmission->status] ?? '';
                        @endphp
                        <div style="display:flex;gap:14px;align-items:flex-start;margin-bottom:16px;">
                            <img src="{{ $memberCardSubmission->photo_url }}" alt="Votre photo"
                                style="width:80px;height:100px;object-fit:cover;border-radius:10px;border:2px solid #e5e7eb;flex-shrink:0;">
                            <div style="flex:1;">
                                <div class="status-badge-big {{ $sClass }} mb-2">{{ $sLabel }}</div>
                                <div style="font-size:.78rem;color:#6b7280;">
                                    Envoyée le {{ optional($memberCardSubmission->submitted_at)->format('d/m/Y à H:i') }}
                                </div>
                                @if($memberCardSubmission->admin_comment)
                                    <div style="margin-top:10px;background:#f8fafc;border:1px solid #e5e7eb;border-radius:8px;padding:10px 12px;font-size:.78rem;color:#374151;">
                                        <strong>Commentaire :</strong> {{ $memberCardSubmission->admin_comment }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div style="background:#fff3cd;border:1px solid #fde68a;border-radius:10px;padding:12px 14px;font-size:.82rem;color:#92400e;margin-bottom:16px;">
                            <strong>📸 Photo attendue !</strong> Veuillez envoyer votre photo d'identité pour que votre carte puisse être fabriquée.
                        </div>
                    @endif
                </div>
            </div>

            {{-- Upload photo --}}
            @if(!$memberCardSubmission || $memberCardSubmission->status === 'revision_requested')
            <div class="carte-status-card">
                <div class="carte-status-header" style="background:linear-gradient(135deg,#C8102E,#a00d25);">
                    <div style="font-size:1.5rem;">📷</div>
                    <div style="font-family:'Montserrat',sans-serif;font-weight:700;color:#fff;font-size:.95rem;">Envoyer ma photo</div>
                </div>
                <div class="carte-status-body" style="padding-top:16px;">

                    <form action="{{ route('militant.member-card-photo.store') }}" method="POST" enctype="multipart/form-data" id="memberCardPhotoForm">
                        @csrf
                        <input type="hidden" name="campaign_id" value="{{ $activeMemberCardCampaign->id }}">
                        <input type="hidden" name="webcam_photo" id="webcam_photo">

                        {{-- Caméra --}}
                        <div style="margin-bottom:16px;">
                            <div style="font-family:'Montserrat',sans-serif;font-weight:700;font-size:.8rem;color:#374151;margin-bottom:10px;">Option 1 — Prendre une photo maintenant</div>
                            <div class="camera-shell">
                                <video id="memberCameraVideo" playsinline autoplay muted></video>
                                <canvas id="memberCameraCanvas" style="display:none;"></canvas>
                                <div class="camera-overlay" id="memberCameraOverlay">
                                    <div>
                                        <div style="font-size:2rem;margin-bottom:8px;">📷</div>
                                        <div style="font-size:.82rem;">Cliquez sur « Ouvrir la caméra » ci-dessous</div>
                                    </div>
                                </div>
                            </div>
                            <div class="camera-btn-row">
                                <button class="portal-btn portal-btn-primary" type="button" id="openCameraBtn">
                                    <i class="fas fa-camera"></i>Ouvrir la caméra
                                </button>
                                <button class="portal-btn portal-btn-success" type="button" id="takePhotoBtn" style="display:none;">
                                    <i class="fas fa-camera-retro"></i>Capturer
                                </button>
                                <button class="portal-btn portal-btn-outline" type="button" id="retakePhotoBtn" style="display:none;">
                                    <i class="fas fa-redo"></i>Reprendre
                                </button>
                            </div>
                            <div class="portal-alert portal-alert-danger" id="memberCameraError" style="display:none;margin-top:8px;"></div>
                        </div>

                        {{-- Upload --}}
                        <div style="font-family:'Montserrat',sans-serif;font-weight:700;font-size:.8rem;color:#374151;margin-bottom:10px;">Option 2 — Téléverser depuis mon appareil</div>
                        <div class="upload-zone" id="uploadZone">
                            <input type="file" name="uploaded_photo" id="uploaded_photo" accept="image/png,image/jpeg,image/jpg,image/webp">
                            <div class="uzi" id="uploadIcon">📁</div>
                            <div style="font-size:.82rem;color:#374151;font-weight:600;" id="uploadLabel">Cliquez ou glissez-déposez votre photo ici</div>
                            <div style="font-size:.72rem;color:#9ca3af;margin-top:4px;">JPG, PNG, WEBP — max 5 Mo</div>
                        </div>

                        <div style="margin-top:16px;">
                            <button class="portal-btn portal-btn-primary" type="submit" style="width:100%;justify-content:center;padding:12px;">
                                <i class="fas fa-cloud-upload-alt"></i>Envoyer ma photo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @else
                <div class="carte-status-card" style="display:flex;align-items:center;justify-content:center;">
                    <div class="empty-state">
                        <div class="es-icon">✅</div>
                        <p>Votre photo a bien été reçue.<br>
                        Les responsables sont en train de la vérifier.<br>
                        <strong>Votre carte sera bientôt prête !</strong></p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif

</div>{{-- /portal-content --}}
</div>{{-- /portal-wrap --}}
@endsection

@section('scripts')
<script>
$(document).ready(function () {

    /* ── Navigation onglets ───────────────────────────── */
    $('.portal-tab').on('click', function () {
        const target = $(this).data('target');
        $('.portal-tab').removeClass('active');
        $(this).addClass('active');
        $('.portal-pane').removeClass('active');
        $('#' + target).addClass('active');
        if (target === 'pane-chat') scrollChatToBottom();
    });

    /* ── Filtres documents ────────────────────────────── */
    let activeType = 'all', activeCat = 'all', searchTerm = '';

    function applyDocFilters() {
        let visible = 0;
        $('.doc-card').each(function () {
            const $c = $(this);
            const typeOk = activeType === 'all' || $c.data('type') === activeType;
            const catOk  = activeCat  === 'all' || $c.data('cat')  === activeCat;
            const src    = ($c.data('title') + ' ' + $c.data('desc') + ' ' + $c.data('type'));
            const searchOk = searchTerm === '' || src.includes(searchTerm);
            const show = typeOk && catOk && searchOk;
            $c.closest('.doc-card').parent().toggle(show);
            if (show) visible++;
        });
        $('#docEmpty').toggle(visible === 0 && $('.doc-card').length > 0);
    }

    $('.filter-pill').on('click', function () {
        const $p = $(this), group = $p.data('group'), val = $p.data('filter');
        $('.filter-pill[data-group="' + group + '"]').removeClass('active');
        $p.addClass('active');
        if (group === 'type') activeType = val;
        else activeCat = val;
        applyDocFilters();
    });

    $('#docSearch').on('input', function () {
        searchTerm = $(this).val().toLowerCase().trim();
        applyDocFilters();
    });

    /* ── Chat : envoi question ────────────────────────── */
    const chatRoute  = "{{ route('militant.messages.store') }}";
    const csrfToken  = $('meta[name="csrf-token"]').attr('content');
    const chatList   = $('#militantChatList');
    const chatFeedback = $('#chatFeedback');
    const sendBtn    = $('#submitQuestionBtn');
    const pendingBadge = $('#pendingChatBadge');

    function scrollChatToBottom() {
        if (chatList.length) chatList.scrollTop(chatList[0].scrollHeight);
    }

    function showFeedback(msg, type) {
        chatFeedback
            .removeClass('portal-alert-success portal-alert-danger')
            .addClass(type === 'success' ? 'portal-alert-success' : 'portal-alert-danger')
            .text(msg)
            .show();
        setTimeout(() => chatFeedback.fadeOut(), 5000);
    }

    function appendMessage(entry) {
        const html = `
        <div class="chat-entry-wrap" data-status="pending">
            <div class="chat-msg-militant">
                <div class="bubble">${escapeHtml(entry.question).replace(/\n/g,'<br>')}</div>
                <div class="bubble-meta">Vous · ${entry.created_at} · <span style="color:#f59e0b;">⏳ En attente</span></div>
            </div>
        </div>`;
        chatList.append(html);
        scrollChatToBottom();
        pendingBadge.text((parseInt(pendingBadge.text()) || 0) + 1);
    }

    function escapeHtml(s) {
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    $('#militantChatForm').on('submit', function (e) {
        e.preventDefault();
        const q = $('#questionInput').val().trim();
        if (!q) return;
        sendBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: chatRoute, method: 'POST',
            contentType: 'application/json',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            data: JSON.stringify({ question: q }),
            success: function (res) {
                $('#questionInput').val('').css('height','44px');
                appendMessage(res.chat);
                showFeedback(res.message || 'Question envoyée !', 'success');
                // Vider l'état vide si présent
                chatList.find('.empty-state').closest('div').remove();
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message || 'Échec de l\'envoi. Réessayez.';
                showFeedback(msg, 'danger');
            },
            complete: function () {
                sendBtn.prop('disabled', false).html('<i class="fas fa-paper-plane"></i>');
            }
        });
    });

    // Textarea auto-resize
    $('#questionInput').on('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // Envoyer avec Entrée (sauf Maj+Entrée)
    $('#questionInput').on('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            $('#militantChatForm').submit();
        }
    });

    scrollChatToBottom();

    /* ── Caméra pour la photo de carte ───────────────── */
    const video    = document.getElementById('memberCameraVideo');
    const canvas   = document.getElementById('memberCameraCanvas');
    const overlay  = document.getElementById('memberCameraOverlay');
    const camError = document.getElementById('memberCameraError');
    const webcamIn = document.getElementById('webcam_photo');
    const openBtn  = document.getElementById('openCameraBtn');
    const takeBtn  = document.getElementById('takePhotoBtn');
    const retakeBtn= document.getElementById('retakePhotoBtn');
    const uploadIn = document.getElementById('uploaded_photo');
    const photoForm= document.getElementById('memberCardPhotoForm');
    const uploadZone= document.getElementById('uploadZone');
    const uploadIcon= document.getElementById('uploadIcon');
    const uploadLabel=document.getElementById('uploadLabel');
    let stream = null, captured = false;

    function stopCam() {
        if (stream) { stream.getTracks().forEach(t => t.stop()); stream = null; }
    }

    async function startCam(silent) {
        if (!video || !navigator.mediaDevices?.getUserMedia) {
            if (!silent && camError) { camError.textContent = 'Caméra non disponible. Utilisez le téléversement ci-dessous.'; camError.style.display = 'block'; }
            return;
        }
        try {
            stopCam();
            stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user', width: { ideal: 1280 }, height: { ideal: 720 } }, audio: false });
            video.srcObject = stream;
            if (overlay) overlay.style.display = 'none';
            captured = false;
            if (canvas) canvas.style.display = 'none';
            if (video)  video.style.display  = 'block';
            if (takeBtn)   takeBtn.style.display   = 'inline-flex';
            if (retakeBtn) retakeBtn.style.display = 'none';
            if (camError)  camError.style.display  = 'none';
        } catch(err) {
            if (!silent && camError) { camError.textContent = 'Impossible d\'ouvrir la caméra. Vérifiez les permissions du navigateur.'; camError.style.display = 'block'; }
        }
    }

    function capturePhoto() {
        if (!video || !canvas || !stream) { if (camError) { camError.textContent = 'La caméra n\'est pas encore active.'; camError.style.display = 'block'; } return; }
        const w = video.videoWidth || 1280, h = video.videoHeight || 720;
        canvas.width = w; canvas.height = h;
        canvas.getContext('2d').drawImage(video, 0, 0, w, h);
        if (webcamIn) webcamIn.value = canvas.toDataURL('image/jpeg', 0.92);
        canvas.style.display = 'block';
        video.style.display  = 'none';
        if (takeBtn)   takeBtn.style.display   = 'none';
        if (retakeBtn) retakeBtn.style.display = 'inline-flex';
        captured = true;
        if (uploadIn) uploadIn.value = '';
    }

    if (openBtn)   openBtn.addEventListener('click',   () => startCam(false));
    if (takeBtn)   takeBtn.addEventListener('click',   capturePhoto);
    if (retakeBtn) retakeBtn.addEventListener('click', () => { captured=false; if(webcamIn)webcamIn.value=''; canvas.style.display='none'; video.style.display='block'; takeBtn.style.display='inline-flex'; retakeBtn.style.display='none'; });

    if (uploadIn) {
        uploadIn.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const name = this.files[0].name;
                if (uploadIcon)  uploadIcon.textContent  = '✅';
                if (uploadLabel) uploadLabel.textContent = name;
                if (webcamIn) webcamIn.value = '';
                captured = false;
            }
        });
    }

    if (photoForm) {
        photoForm.addEventListener('submit', stopCam);
        startCam(true);
    }

    document.addEventListener('visibilitychange', () => { if (document.hidden) stopCam(); });
    window.addEventListener('beforeunload', stopCam);

});
</script>
@endsection
