<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
/*
 * LETTRE OFFICIELLE SYNEM
 * dompdf 3.x — approche fiable : body margin (pas @page margin)
 * Police : Times New Roman 12pt | Interligne : 1.5 | Format A4
 */

@page { size: A4 portrait; margin: 0; }

body {
    margin: 31pt 28pt 25pt 28pt;
    padding: 0;
    font-family: 'Times New Roman', Times, serif;
    font-size: 9.5pt;
    line-height: 1.12;
    color: #000;
}

/* ─── RESET ──────────────────────────────────────────────── */
table  { border-collapse: collapse; }
p      { margin: 0 0 7pt 0; }

/* ─── EN-TÊTE ────────────────────────────────────────────── */
#entete {
    width: 100%;
    margin-bottom: 1pt;
}
#entete td { vertical-align: top; }
#col-orga  { width: 55%; padding-right: 10pt; text-align: center; }
#col-meta  { width: 45%; text-align: center; padding-top: 50pt; }

.titre-org   { font-size: 9pt; font-weight: bold; color: #000; }
.sigle-org   { font-size: 9pt; font-weight: bold; color: #000; margin-bottom: 6pt; }
.contacts    { font-size: 8.5pt; font-weight: bold; line-height: 1.15; margin-top: 1pt; }
.logo-synem  { width: 55pt; height: 55pt; object-fit: contain; margin-top: 3pt; }

.devise-box  {
    font-style: italic;
    font-weight: bold;
    font-size: 9.5pt;
}
.lieu-date   { font-size: 9pt; font-style: italic; font-weight: bold; margin-top: 36pt; }

/* ─── DESTINATAIRE ───────────────────────────────────────── */
#destinataire-wrap {
    text-align: right;
    margin: -2pt 0 8pt 0;
    padding-left: 43%;
}
#destinataire-box {
    display: inline-block;
    font-size: 10pt;
    font-weight: bold;
    line-height: 1.18;
    text-align: center;
}

/* ─── RÉFÉRENCES ─────────────────────────────────────────── */
#refs { width: 100%; margin-bottom: 8pt; }
#refs td.label {
    font-weight: bold;
    text-decoration: underline;
    width: 36pt;
    vertical-align: top;
    padding-right: 6pt;
    white-space: nowrap;
    font-size: 9.5pt;
}
#refs td.valeur { font-size: 9.5pt; vertical-align: top; }
#refs tr:first-child td { font-style: italic; font-weight: bold; text-decoration: underline; }

/* ─── CORPS ──────────────────────────────────────────────── */
#corps {
    font-size: 9pt;
    line-height: 1.12;
    text-align: justify;
    word-wrap: break-word;
    margin-bottom: 7pt;
}
#corps p { margin-bottom: 7pt; }

/* ─── BAS DE PAGE ────────────────────────────────────────── */
#bas {
    width: 100%;
    margin-top: 7pt;
    page-break-inside: avoid;
}
#bas td { vertical-align: top; }
#col-amp { width: 46%; padding-right: 12pt; }
#col-sig { width: 54%; text-align: center; }

.amp-titre { font-weight: bold; text-decoration: underline; font-size: 9.5pt; }
.amp-item  { font-size: 9pt; line-height: 1.25; }

.sig-fonction { font-weight: bold; font-size: 9.5pt; margin-bottom: 2pt; }
.sig-espace   { height: 45pt; }
.sig-images   { width: 100%; border-collapse: collapse; }
.sig-images td { text-align: center; vertical-align: bottom; padding: 0 4pt; }
.sig-images img { max-height: 62pt; max-width: 100pt; }
.sig-nom { font-weight: bold; font-size: 9.5pt; text-decoration: underline; margin-top: 1pt; }

/* ─── PIED ───────────────────────────────────────────────── */
</style>
</head>
<body>

{{-- ═════════════ EN-TÊTE ════════════════════════════════ --}}
<table id="entete">
<tr>
  <td id="col-orga">
    <div class="titre-org">Confédération Syndicale des Travailleurs du Mali</div>
    <div class="sigle-org">CSTM</div>
    <div class="titre-org">Fédération de l'Éducation Nationale</div>
    <div class="sigle-org">FEN</div>
    <div class="titre-org">Syndicat National des Enseignants du Mali</div>
    <div class="sigle-org">(SYNEM)<br>Bureau Exécutif National<br>BEN/SYNEM</div>
    <div class="contacts">
      Siège Ex Imm. SONAVIE<br>
      au quartier du fleuve Rue : 303 / Porte : 264<br>
      Tél : 20 23 82 59 / Fax : 20 22 02 75<br>
      Cell : 75 41 29 84 / 65 61 81 71
    </div>
    <img class="logo-synem" src="{{ public_path('template-admin/assets/images/syneklogo.jpeg') }}" alt="Logo SYNEM">
  </td>
  <td id="col-meta">
    <div class="devise-box">« Unité–Action–Justice »</div>
    <div class="lieu-date">Bamako, le {{ $lettre->date_lettre->translatedFormat('d F Y') }}</div>
  </td>
</tr>
</table>

{{-- ═════════════ DESTINATAIRE (aligné à droite) ══════════ --}}
<div id="destinataire-wrap">
  <div id="destinataire-box">
    {!! nl2br(e($lettre->destinataire)) !!}
  </div>
</div>

{{-- ═════════════ N° ET OBJET ══════════════════════════════ --}}
<table id="refs">
  <tr>
    <td class="label">Lettre</td>
    <td class="valeur">N°{{ $lettre->numero }}</td>
  </tr>
  <tr>
    <td class="label" style="padding-top:2pt;">Objet :</td>
    <td class="valeur" style="padding-top:2pt;">{!! nl2br(e($lettre->objet)) !!}</td>
  </tr>
</table>

{{-- ═════════════ CORPS ═════════════════════════════════════ --}}
@php
    $texte = $lettre->corps ?? '';
    $texte = str_replace(["\r\n", "\r"], "\n", $texte);
    $blocs = array_filter(array_map('trim', preg_split('/\n{2,}/', $texte)));
@endphp
<div id="corps">
  @foreach($blocs as $bloc)
    <p>{!! nl2br(e($bloc)) !!}</p>
  @endforeach
</div>

{{-- ═════════════ AMPLIATIONS + SIGNATURE ══════════════════ --}}
<table id="bas">
<tr>
  <td id="col-amp">
    @if($lettre->ampliations && count($lettre->ampliations))
    <div class="amp-titre">Ampliations :</div>
    @foreach($lettre->ampliations as $a)
      <div class="amp-item">— {{ $a }}</div>
    @endforeach
    @endif
  </td>
  <td id="col-sig">
    <div class="sig-fonction">{{ $lettre->fonction_signataire }}</div>
    @if($lettre->signature_path || $lettre->cachet_path)
      <table class="sig-images"><tr>
        @if($lettre->signature_path)
        <td>
          <img src="{{ storage_path('app/public/'.$lettre->signature_path) }}" alt="Signature">
        </td>
        @endif
        @if($lettre->cachet_path)
        <td>
          <img src="{{ storage_path('app/public/'.$lettre->cachet_path) }}" alt="Sceau">
        </td>
        @endif
      </tr></table>
    @else
      <div class="sig-espace"></div>
    @endif
    <div class="sig-nom">{{ $lettre->signataire }}</div>
  </td>
</tr>
</table>

</body>
</html>
