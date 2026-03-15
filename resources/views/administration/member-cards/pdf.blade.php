<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Cartes membres SYNEM</title>
    <style>
        @page { margin: 10px; }
        body { font-family: DejaVu Sans, sans-serif; margin: 0; color: #111827; }
        .sheet { width: 100%; font-size: 0; }
        .card-item {
            width: 63mm;
            height: 40mm;
            display: inline-block;
            vertical-align: top;
            margin: 0 1.4mm 2mm 0;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            overflow: hidden;
            page-break-inside: avoid;
            background: #ffffff;
            font-size: 7px;
            box-sizing: border-box;
        }
        .motto { font-size: 5px; text-transform: uppercase; letter-spacing: .3px; }
        .card-header {
            padding: 3px 5px;
        }
        .header-table,
        .body-table,
        .flag-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        .brand-cell {
            width: 26px;
            text-align: right;
            vertical-align: top;
        }
        .brand-img {
            width: 22px;
            height: 22px;
            object-fit: contain;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 6px;
            padding: 2px;
        }
        .title { font-size: 5px; text-transform: uppercase; letter-spacing: .4px; }
        .subtitle { font-size: 10px; font-weight: bold; margin-top: 1px; }
        .card-body { padding: 4px 5px 2px; }
        .photo-cell {
            width: 52px;
            vertical-align: top;
        }
        .info-cell {
            vertical-align: top;
        }
        .qr-cell {
            width: 40px;
            text-align: right;
            vertical-align: top;
        }
        .photo {
            width: 15.5mm;
            height: 19.5mm;
            object-fit: cover;
            border-radius: 6px;
            display: block;
        }
        .meta { font-size: 5.8px; line-height: 1.22; }
        .footer {
            padding: 2px 5px 3px;
            border-top: 1px solid #e5e7eb;
            font-size: 5px;
        }
        .qr {
            width: 12.8mm;
            height: 12.8mm;
            object-fit: contain;
        }
        .flag-band { height: 2px; }
        .signature {
            max-width: 18mm;
            max-height: 6mm;
            object-fit: contain;
            display: block;
            margin: 1px 0 2px;
        }
        .signature-text {
            display: block;
            margin: 1px 0 2px;
            font-size: 8px;
            font-style: italic;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="sheet">
        @foreach($cards as $card)
            @php
                $cardItemStyle = 'background: ' . $template['accent'] . '; border: ' . ($card['show_border'] ? ('1px solid ' . $template['primary']) : '0 none') . ';';
                $cardHeaderStyle = 'background: ' . $template['primary'] . '; color: ' . $card['header_text_color'] . ';';
                $bodyStyle = 'color: ' . $card['text_color'] . ';';
                $footerStyle = 'color: ' . $card['text_color'] . ';';
            @endphp
            <div class="card-item" style="<?php echo e($cardItemStyle); ?>">
                <div class="card-header" style="<?php echo e($cardHeaderStyle); ?>">
                    <table class="header-table">
                        <tr>
                            <td>
                                <div class="motto">{{ $card['header_motto'] }}</div>
                                <div class="subtitle">CARTE DE MEMBRE</div>
                                <div class="title">Numero: {{ $card['card_number'] }}</div>
                            </td>
                            <td class="brand-cell">
                                @if($card['show_logo'] && $card['logo'])
                                    <img class="brand-img" src="{{ $card['logo'] }}" alt="Logo SYNEM">
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                @if($card['show_flag_band'])
                    <table class="flag-table flag-band">
                        <tr>
                            <td bgcolor="#0b8f3c"></td>
                            <td bgcolor="#f2c94c"></td>
                            <td bgcolor="#d62828"></td>
                        </tr>
                    </table>
                @endif

                <div class="card-body" style="<?php echo e($bodyStyle); ?>">
                    <table class="body-table">
                        <tr>
                            <td class="photo-cell">
                                <img class="photo" src="{{ $card['photo'] }}" alt="Photo membre">
                            </td>
                            <td class="info-cell">
                                <div class="meta"><strong>N° carte :</strong> {{ $card['card_number'] }}</div>
                                <div class="meta"><strong>Nom :</strong> {{ $card['nom'] }}</div>
                                <div class="meta"><strong>Prenom :</strong> {{ $card['prenom'] }}</div>
                                <div class="meta"><strong>Division :</strong> {{ $card['division'] }}</div>
                                <div class="meta"><strong>Coord. / Region :</strong> {{ $card['region'] }}</div>
                                <div class="meta"><strong>Telephone :</strong> {{ $card['phone'] }}</div>
                                <div class="meta"><strong>Prix :</strong> {{ $card['price_label'] }}</div>
                            </td>
                            @if($card['show_qr'] && $card['qr_code'])
                                <td class="qr-cell">
                                    <img class="qr" src="{{ $card['qr_code'] }}" alt="QR code">
                                </td>
                            @endif
                        </tr>
                    </table>
                </div>

                <div class="footer" style="<?php echo e($footerStyle); ?>">
                    @if($card['show_secretary_block'])
                        @if($card['signature_image'])
                            <img class="signature" src="{{ $card['signature_image'] }}" alt="Signature du signataire">
                        @elseif($card['signature_text'])
                            <span class="signature-text">{{ $card['signature_text'] }}</span>
                        @endif
                        <strong>{{ $card['secretary_general_title'] }} :</strong> {{ $card['secretary_general_name'] }}<br>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>