@php
    $pageTitle = isset($pageTitle) ? trim((string) $pageTitle) : '';
    $breadcrumb = isset($breadcrumb) ? trim((string) $breadcrumb) : '';

    $images = (isset($images) && is_array($images) && count($images) > 0)
        ? $images
        : [asset('template-siteweb/asset/img/r.jpg')];

    $captions = (isset($captions) && is_array($captions)) ? $captions : [];
@endphp

<!-- Page Carousel Start -->
<div class="container-fluid p-0" style="margin-bottom: 90px;">
    <div id="page-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($images as $index => $image)
            @php
                $captionText = trim((string) ($captions[$index] ?? ''));
            @endphp
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img class="w-100" src="{{ $image }}" alt="{{ $pageTitle }}">
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3" style="max-width: 900px;">
                        @if($pageTitle !== '')
                            <h1 class="display-3 text-white mb-3 animated slideInDown">{{ $pageTitle }}</h1>
                        @endif

                        @if($captionText !== '')
                            <p class="display-6 text-white mb-4 animated slideInDown">{{ $captionText }}</p>
                        @endif

                        @if($breadcrumb !== '')
                            <nav aria-label="breadcrumb animated slideInDown">
                                <ol class="breadcrumb justify-content-center mb-0">
                                    <li class="breadcrumb-item"><a class="text-white" href="{{ route('accueil') }}">Accueil</a></li>
                                    <li class="breadcrumb-item text-white active" aria-current="page">{{ $breadcrumb }}</li>
                                </ol>
                            </nav>
                        @endif
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