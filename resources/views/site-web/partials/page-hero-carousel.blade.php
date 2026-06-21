@php
    $heroId = $heroId ?? 'pageHeroCarousel';
    $heroSlides = collect($heroSlides ?? []);
    if ($heroSlides->isEmpty()) {
        $heroSlides = collect($fallbackImages ?? [asset('template-siteweb/asset/img/avenir_mali.png')])
            ->map(fn ($image) => ['image_url' => $image, 'title' => null, 'caption' => null]);
    }
@endphp

<section class="page-hero page-hero-carousel">
    <div id="{{ $heroId }}" class="carousel slide" data-ride="carousel" data-interval="5500">
        <div class="carousel-inner">
            @foreach($heroSlides as $index => $slide)
                @php
                    $imageUrl = data_get($slide, 'image_url') ?: data_get($slide, 'image');
                @endphp
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="page-hero-bg" style="background-image:url('{{ $imageUrl }}')"></div>
                </div>
            @endforeach
        </div>
        @if($heroSlides->count() > 1)
            <ol class="carousel-indicators">
                @foreach($heroSlides as $index => $slide)
                    <li data-target="#{{ $heroId }}" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <a class="carousel-control-prev" href="#{{ $heroId }}" role="button" data-slide="prev"><span class="carousel-control-prev-icon"></span></a>
            <a class="carousel-control-next" href="#{{ $heroId }}" role="button" data-slide="next"><span class="carousel-control-next-icon"></span></a>
        @endif
    </div>
    <div class="page-hero-overlay"></div>
    <div class="page-hero-content">
        <span class="page-label">{{ $heroLabel }}</span>
        <h1>{{ $heroTitle }}</h1>
        <div class="hero-divider"></div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('accueil') }}">Accueil</a></li>
                <li class="breadcrumb-item active">{{ $heroBreadcrumb }}</li>
            </ol>
        </nav>
    </div>
    <div class="page-hero-scroll"><i class="fa fa-chevron-down"></i></div>
</section>
<div class="page-header-accent"></div>
