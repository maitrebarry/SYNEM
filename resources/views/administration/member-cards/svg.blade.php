<svg xmlns="http://www.w3.org/2000/svg" width="856" height="540" viewBox="0 0 856 540">
    <rect x="8" y="8" width="840" height="524" rx="32" fill="{{ $template['accent'] }}" stroke="{{ $card['show_border'] ? $template['primary'] : $template['accent'] }}" stroke-width="{{ $card['show_border'] ? '10' : '0' }}"/>
    <rect x="22" y="22" width="812" height="86" rx="22" fill="{{ $template['primary'] }}"/>
    @if($card['show_flag_band'])
        <rect x="22" y="112" width="270" height="18" fill="#0b8f3c"/>
        <rect x="292" y="112" width="270" height="18" fill="#f2c94c"/>
        <rect x="562" y="112" width="272" height="18" fill="#d62828"/>
    @endif
    <text x="40" y="60" fill="{{ $card['header_text_color'] }}" font-size="24" font-family="Arial, sans-serif">{{ $card['header_motto'] }}</text>
    <text x="40" y="96" fill="{{ $card['header_text_color'] }}" font-size="42" font-weight="700" font-family="Arial, sans-serif">CARTE DE MEMBRE</text>
    @if($card['show_logo'] && $card['logo'])
        <image href="{{ $card['logo'] }}" x="730" y="34" width="74" height="74"/>
    @endif
    <rect x="42" y="152" width="192" height="230" rx="18" fill="#ffffff" stroke="{{ $template['secondary'] }}" stroke-width="6"/>
    <image href="{{ $card['photo'] }}" x="52" y="162" width="172" height="210" preserveAspectRatio="xMidYMid slice"/>
    <text x="270" y="174" fill="{{ $card['text_color'] }}" font-size="20" font-weight="700" font-family="Arial, sans-serif">Numero: {{ $card['card_number'] }}</text>
    <text x="270" y="214" fill="{{ $card['text_color'] }}" font-size="20" font-family="Arial, sans-serif">Nom: {{ $card['nom'] }}</text>
    <text x="270" y="248" fill="{{ $card['text_color'] }}" font-size="20" font-family="Arial, sans-serif">Prenom: {{ $card['prenom'] }}</text>
    <text x="270" y="282" fill="{{ $card['text_color'] }}" font-size="20" font-family="Arial, sans-serif">Division: {{ $card['division'] }}</text>
    <text x="270" y="316" fill="{{ $card['text_color'] }}" font-size="20" font-family="Arial, sans-serif">Coordination / Region: {{ $card['region'] }}</text>
    <text x="270" y="350" fill="{{ $card['text_color'] }}" font-size="20" font-family="Arial, sans-serif">Telephone: {{ $card['phone'] }}</text>
    <text x="270" y="384" fill="{{ $card['text_color'] }}" font-size="20" font-family="Arial, sans-serif">Prix: {{ $card['price_label'] }}</text>
    @if($card['show_qr'] && $card['qr_code'])
        <rect x="626" y="280" width="178" height="178" rx="16" fill="#ffffff"/>
        <image href="{{ $card['qr_code'] }}" x="640" y="294" width="150" height="150"/>
    @endif
    @if($card['show_secretary_block'])
        @if($card['signature_image'])
            <image href="{{ $card['signature_image'] }}" x="42" y="392" width="180" height="48" preserveAspectRatio="xMidYMid meet"/>
        @elseif($card['signature_text'])
            <text x="42" y="430" fill="{{ $card['text_color'] }}" font-size="28" font-style="italic" font-weight="700" font-family="Arial, sans-serif">{{ $card['signature_text'] }}</text>
        @endif
        <text x="42" y="450" fill="{{ $card['text_color'] }}" font-size="22" font-weight="700" font-family="Arial, sans-serif">{{ $card['secretary_general_title'] }}</text>
        <text x="42" y="482" fill="{{ $card['text_color'] }}" font-size="20" font-family="Arial, sans-serif">{{ $card['secretary_general_name'] }}</text>
    @endif
</svg>