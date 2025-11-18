@php
    $pageTitle = $pageTitle ?? 'Titre de la page';
    $breadcrumb = $breadcrumb ?? 'Page actuelle';
    $images = $images ?? [asset('template-siteweb/asset/img/r.jpg')];
    $captions = $captions ?? ['Default caption'];
@endphp

<!-- Page Carousel Start -->
<div class="container-fluid p-0" style="margin-bottom: 90px;">
    <div id="page-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($images as $index => $image)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img class="w-100" src="{{ $image }}" alt="{{ $pageTitle }}">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px;">
                        <h1 class="display-3 text-white mb-3 animated slideInDown">{{ $pageTitle }}</h1>
                        <p class="display-6 text-white mb-4 animated slideInDown">{{ $captions[$index] ?? '' }}</p>
                        <nav aria-label="breadcrumb animated slideInDown">
                            <ol class="breadcrumb justify-content-center mb-0">
                                <li class="breadcrumb-item"><a class="text-white" href="{{ route('accueil') }}">Accueil</a></li>
                                <li class="breadcrumb-item text-white active" aria-current="page">{{ $breadcrumb }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if(count($images) > 1)
        <a class="carousel-control-prev" href="#page-carousel" role="button" data-slide="prev">
            <div class="btn btn-dark btn-lg-square" style="width: 45px; height: 45px;">
                <span class="carousel-control-prev-icon"></span>
            </div>
        </a>
        <a class="carousel-control-next" href="#page-carousel" role="button" data-slide="next">
            <div class="btn btn-dark btn-lg-square" style="width: 45px; height: 45px;">
                <span class="carousel-control-next-icon"></span>
            </div>
        </a>
        @endif
    </div>
</div>
<!-- Page Carousel End -->