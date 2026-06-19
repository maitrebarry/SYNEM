<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Cartes membres SYNEM</title>
    <style>
        @page { size: A4 portrait; margin: 8mm; }

        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            font-size: 0;
            color: #111827;
            background: #fff;
        }

        /* ── CARTE : 85mm × 54mm ──────────────────────── */
        .card-item {
            width: 85mm;
            height: 54mm;
            display: inline-block;
            vertical-align: top;
            margin: 0 2mm 3mm 0;
            border-radius: 2.5mm;
            overflow: hidden;
            page-break-inside: avoid;
            background: #ffffff;
            box-sizing: border-box;
            font-size: 0;
        }

        /* Budget vertical (doit tenir dans 54mm) :
           En-tête  : 8mm
           Tricolore: 1.5mm
           N° carte : 4mm
           Corps    : 28mm   (photo 22mm + 3mm pad haut/bas)
           Pied     : 12.5mm (QR 11mm + 1.5mm pad)
           Total    : 54mm   ✓                                */

        /* ── 1. EN-TÊTE (8mm) ────────────────────────── */
        .c-header {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        .c-header td {
            padding: 1.2mm 2mm 0.8mm;
            vertical-align: middle;
        }
        .c-logo-cell { width: 8mm; padding-right: 0 !important; }
        .c-logo {
            width: 7mm;
            height: 7mm;
            object-fit: contain;
            display: block;
        }
        .c-title-cell { text-align: center; }
        .c-motto {
            font-size: 6px;
            font-weight: bold;
            color: #C8102E;
            text-transform: uppercase;
            letter-spacing: .3px;
            line-height: 1.2;
            display: block;
        }
        .c-spacer { width: 8mm; }

        /* ── 2. BANDE TRICOLORE (1.5mm) ──────────────── */
        .c-flag {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            height: 1.5mm;
        }
        .c-flag td { height: 1.5mm; padding: 0; }

        /* ── 3. NUMÉRO DE CARTE (4mm) ────────────────── */
        .c-cardnum {
            display: block;
            text-align: center;
            padding: 0.8mm 2mm 0.6mm;
            font-size: 7.5px;
            font-weight: bold;
            color: #C8102E;
            text-transform: uppercase;
            letter-spacing: .4px;
            background: #fff;
            border-bottom: 0.5px solid #e5e7eb;
        }

        /* ── 4. CORPS : champs + photo (28mm) ────────── */
        .c-body {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        .c-body td { padding: 1.5mm 2mm 1mm; vertical-align: top; }
        .c-fields-cell { padding-right: 1mm !important; }
        .c-photo-cell {
            width: 18mm;
            text-align: center;
            padding-left: 0 !important;
            padding-right: 2mm !important;
        }
        .c-photo {
            width: 16mm;
            height: 22mm;
            object-fit: cover;
            border: 0.6px solid #9ca3af;
            display: block;
        }
        .c-photo-blank {
            width: 16mm;
            height: 22mm;
            background: #f3f4f6;
            border: 0.6px solid #9ca3af;
            display: block;
        }

        /* lignes de champ */
        .c-field {
            display: block;
            font-size: 5.5px;
            line-height: 1.5;
            border-bottom: 0.4px solid #9ca3af;
            margin-bottom: 1mm;
            padding-bottom: 0.4mm;
            color: #111827;
        }
        .c-field b { font-size: 5.5px; }

        /* ── 5. PIED : prix/tél | secrétaire | QR (12.5mm) */
        .c-footer {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            border-top: 0.5px solid #d1d5db;
        }
        .c-footer td { padding: 0.6mm 2mm 0.8mm; vertical-align: middle; }

        .c-price-cell { }
        .c-price-lbl {
            display: block;
            font-size: 5.5px;
            font-weight: bold;
            color: #111827;
            line-height: 1.5;
        }
        .c-tel-lbl {
            display: block;
            font-size: 5px;
            color: #374151;
            border-bottom: 0.4px solid #9ca3af;
            line-height: 1.5;
        }

        .c-sec-cell {
            text-align: right;
            width: 30mm;
        }
        .c-sec-title {
            display: block;
            font-size: 4.8px;
            text-transform: uppercase;
            letter-spacing: .3px;
            color: #6b7280;
            line-height: 1.3;
        }
        .c-sec-sig {
            max-width: 18mm;
            max-height: 5mm;
            object-fit: contain;
            display: inline-block;
        }
        .c-sec-sig-text {
            display: block;
            font-size: 7px;
            font-style: italic;
            font-weight: bold;
            color: #111827;
        }
        .c-sec-name {
            display: block;
            font-size: 5.2px;
            font-weight: bold;
            color: #111827;
            line-height: 1.3;
        }

        .c-qr-cell {
            width: 13mm;
            text-align: right;
            padding-right: 1.5mm !important;
        }
        .c-qr {
            width: 11mm;
            height: 11mm;
            object-fit: contain;
            display: block;
        }
    </style>
</head>
<body>
<div class="sheet">
    @foreach($cards as $card)
        @php
            $borderColor = $card['show_border'] ? '1.8px solid #1a3a6b' : '1px solid #e5e7eb';
        @endphp

        <div class="card-item" style="border: {{ $borderColor }};">

            {{-- 1. En-tête --}}
            <table class="c-header">
                <tr>
                    <td class="c-logo-cell">
                        @if($card['show_logo'] && $card['logo'])
                            <img class="c-logo" src="{{ $card['logo'] }}" alt="SYNEM">
                        @endif
                    </td>
                    <td class="c-title-cell">
                        <span class="c-motto">{{ $card['header_motto'] }}</span>
                    </td>
                    <td class="c-spacer"></td>
                </tr>
            </table>

            {{-- 2. Bande tricolore --}}
            @if($card['show_flag_band'])
                <table class="c-flag">
                    <tr>
                        <td bgcolor="#0b8f3c"></td>
                        <td bgcolor="#f2c94c"></td>
                        <td bgcolor="#d62828"></td>
                    </tr>
                </table>
            @endif

            {{-- 3. Numéro de carte --}}
            <span class="c-cardnum">CARTE DE MEMBRE &nbsp; N° {{ $card['card_number'] }}</span>

            {{-- 4. Corps --}}
            <table class="c-body">
                <tr>
                    <td class="c-fields-cell">
                        <span class="c-field"><b>Nom :</b> {{ $card['nom'] }}</span>
                        <span class="c-field"><b>Prénom :</b> {{ $card['prenom'] }}</span>
                        <span class="c-field"><b>DIVISION :</b> {{ $card['division'] }}</span>
                        <span class="c-field"><b>Coord. Rég. :</b> {{ $card['coordination'] }}</span>
                    </td>
                    <td class="c-photo-cell">
                        @if($card['photo'])
                            <img class="c-photo" src="{{ $card['photo'] }}" alt="Photo">
                        @else
                            <div class="c-photo-blank"></div>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- 5. Pied --}}
            <table class="c-footer">
                <tr>
                    <td class="c-price-cell">
                        <span class="c-price-lbl">Prix : {{ $card['price_label'] }}</span>
                        <span class="c-tel-lbl">N° Tél : {{ $card['phone'] }}</span>
                    </td>
                    @if($card['show_secretary_block'])
                        <td class="c-sec-cell">
                            <span class="c-sec-title">{{ $card['secretary_general_title'] }}</span>
                            @if($card['signature_image'])
                                <img class="c-sec-sig" src="{{ $card['signature_image'] }}" alt="">
                            @elseif($card['signature_text'])
                                <span class="c-sec-sig-text">{{ $card['signature_text'] }}</span>
                            @endif
                            <span class="c-sec-name">{{ $card['secretary_general_name'] }}</span>
                        </td>
                    @endif
                    @if($card['show_qr'] && $card['qr_code'])
                        <td class="c-qr-cell">
                            <img class="c-qr" src="{{ $card['qr_code'] }}" alt="QR">
                        </td>
                    @endif
                </tr>
            </table>

        </div>
    @endforeach
</div>
</body>
</html>
