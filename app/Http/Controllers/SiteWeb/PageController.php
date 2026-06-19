<?php

namespace App\Http\Controllers\SiteWeb;

use App\Http\Controllers\Controller;
use App\Models\AboutPageContent;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PageController extends Controller
{
    public function aPropos()
    {
        return view('site-web.pages.a-propos', [
            'titre' => 'À propos - SYNEM',
            'about' => AboutPageContent::first(),
            'visitorCount' => Schema::hasTable('visitors') ? Visitor::count() : 0,
        ]);
    }

    public function mission()
    {
        // Load mission page data (if present) and build view-friendly arrays
        try {
            $page = \App\Models\MissionPage::first();
        } catch (\Throwable $e) {
            $page = null;
        }

        $carouselImages = [
            asset('template-siteweb/asset/img/bg.jpg'),
            asset('template-siteweb/asset/img/gallery-2.jpg'),
            asset('template-siteweb/asset/img/gallery-3.jpg')
        ];
        // Captions are optional. By default, don't show any static text.
        $carouselCaptions = [];

        $missionImage = asset('template-siteweb/asset/img/mission-demo.jpg');
        $missionMain = 'La mission du SYNEM est de défendre les intérêts moraux et matériels des enseignants, d’améliorer leurs conditions de travail, et de promouvoir le respect et la reconnaissance du métier. Le syndicat agit pour une école inclusive, équitable et performante au Mali.';

        $missions = [
            ['icon' => 'fa fa-balance-scale', 'title' => 'Défense des Droits', 'text' => 'Protéger les droits professionnels, sociaux et économiques des enseignants à tous les niveaux.'],
            ['icon' => 'fa fa-graduation-cap', 'title' => 'Formation Continue', 'text' => 'Organiser des programmes de formation pour le développement professionnel des enseignants.'],
            ['icon' => 'fa fa-handshake', 'title' => 'Dialogue Social', 'text' => 'Faciliter le dialogue entre les enseignants, l\'administration et les autorités éducatives.'],
            ['icon' => 'fa fa-chart-line', 'title' => 'Promotion de l\'Éducation', 'text' => 'Contribuer à l\'amélioration de la qualité de la l\'éducation au Mali.'],
            ['icon' => 'fa fa-users', 'title' => 'Représentation', 'text' => 'Représenter les enseignants dans toutes les instances décisionnelles.'],
            ['icon' => 'fa fa-shield-alt', 'title' => 'Protection Sociale', 'text' => 'Assurer la protection sociale et la sécurité des enseignants.'],
        ];

        $values = [
            ['icon' => 'fa fa-star', 'title' => 'Excellence', 'text' => 'Nous visons l\'excellence dans tous nos services et actions.'],
            ['icon' => 'fa fa-hand-holding-heart', 'title' => 'Solidarité', 'text' => 'La solidarité entre enseignants est au cœur de notre action.'],
            ['icon' => 'fa fa-scale-balanced', 'title' => 'Équité', 'text' => 'Nous promouvons l\'équité et la justice pour tous les enseignants.'],
            ['icon' => 'fa fa-eye', 'title' => 'Transparence', 'text' => 'Nous agissons avec transparence dans toutes nos décisions.'],
        ];

        $cta = ['title' => 'Rejoignez Notre Mission', 'subtitle' => 'Ensemble, construisons un avenir meilleur pour l\'éducation au Mali.', 'button_text' => 'Nous Rejoindre', 'link' => route('contact')];

        if ($page) {
            // header images
            $hdr = $page->headerImages()->orderBy('id')->get();
            if ($hdr->isNotEmpty()) {
                $carouselImages = $hdr->map(fn($h) => asset('storage/mission_header/' . $h->file))->toArray();
                $carouselCaptions = $hdr->map(fn($h) => $h->caption ?? '')->toArray();
            }
            // main
            if (!empty($page->mission_image)) {
                $missionImage = asset('storage/' . $page->mission_image);
            }
            if (!empty($page->mission_main)) {
                $missionMain = $page->mission_main;
            }
            // missions
            $its = $page->items()->orderBy('ordering')->orderBy('id')->get();
            if ($its->isNotEmpty()) {
                $missions = $its->map(fn($it) => ['icon' => $it->icon ?: 'fa fa-circle', 'title' => $it->title, 'text' => $it->text])->toArray();
            }
            // values
            $vals = $page->values()->orderBy('ordering')->orderBy('id')->get();
            if ($vals->isNotEmpty()) {
                $values = $vals->map(fn($v) => ['icon' => $v->icon ?: 'fa fa-star', 'title' => $v->title, 'text' => $v->text])->toArray();
            }
            // cta
            if (!empty($page->mission_cta) && is_array($page->mission_cta)) {
                $cta = array_merge($cta, $page->mission_cta);
            }
        }

        return view('site-web.pages.mission', [
            'titre' => 'Notre mission - SYNEM',
            'page' => $page,
            'carouselImages' => $carouselImages,
            'carouselCaptions' => $carouselCaptions,
            'missionImage' => $missionImage,
            'missionMain' => $missionMain,
            'missions' => $missions,
            'values' => $values,
            'cta' => $cta,
        ]);
    }

    public function historique()
    {
        // Default events (fallback if DB table is missing or empty)
        $fallback = [
            ['year' => '1990', 'title' => 'Premier bureau élu', 'text' => "Élection du premier bureau du SYNEM, marquant le démarrage officiel des activités syndicales."] ,
            ['year' => '1991', 'title' => 'Adoption des statuts initiaux', 'text' => "Adoption des statuts fondateurs qui définissent l'organisation et les objectifs du syndicat."],
            ['year' => '1995', 'title' => 'Premier Congrès National', 'text' => "Organisation du premier congrès national avec la participation de délégués de toutes les régions."],
            ['year' => '2000', 'title' => 'Lancement des Programmes de Formation', 'text' => "Mise en place du premier programme national de formation continue pour les enseignants."],
            ['year' => '2010', 'title' => 'Accord Historique', 'text' => "Signature d'un accord important avec le gouvernement pour améliorer les conditions de travail."],
            ['year' => '2020', 'title' => 'Digitalisation', 'text' => "Lancement de la plateforme numérique du SYNEM pour moderniser les services aux membres."],
        ];

        // Try to load persisted events from the DB if the table/model exists
        try {
            if (class_exists(\App\Models\HistoriqueEvent::class)) {
                $rows = \App\Models\HistoriqueEvent::orderBy('ordering')->orderBy('id')->get();
                if ($rows->isNotEmpty()) {
                    $events = $rows->map(function ($r) {
                        return [
                            'id' => $r->id,
                            'year' => $r->year,
                            'title' => $r->title,
                            'text' => $r->text,
                            'image' => $r->image ? asset('storage/historique/' . $r->image) : null,
                            'icon' => $r->icon,
                            'ordering' => $r->ordering,
                        ];
                    })->toArray();
                } else {
                    $events = $fallback;
                }
            } else {
                $events = $fallback;
            }
        } catch (\Throwable $e) {
            // If anything goes wrong, fall back to static sample events
            $events = $fallback;
        }

        // Try to load main section, milestones and archives
        $main = null;
        $milestones = null;
        $archives = null;
        try {
            if (class_exists(\App\Models\HistoriqueMain::class)) {
                $main = \App\Models\HistoriqueMain::first();
            }
        } catch (\Throwable $e) { $main = null; }

        try {
            if (class_exists(\App\Models\Milestone::class)) {
                $ms = \App\Models\Milestone::orderBy('ordering')->orderBy('id')->get();
                if ($ms->isNotEmpty()) {
                    $milestones = $ms->map(fn($m) => ['number' => $m->number, 'label' => $m->label, 'description' => $m->description, 'icon' => $m->icon, 'ordering' => $m->ordering])->toArray();
                }
            }
        } catch (\Throwable $e) { $milestones = null; }

        try {
            if (class_exists(\App\Models\Archive::class)) {
                $ars = \App\Models\Archive::orderBy('ordering')->orderBy('id')->get();
                if ($ars->isNotEmpty()) {
                    $archives = $ars->map(fn($a) => ['title' => $a->title, 'text' => $a->text, 'image' => $a->image ? asset('storage/historique/' . $a->image) : null, 'link' => $a->link, 'ordering' => $a->ordering])->toArray();
                }
            }
        } catch (\Throwable $e) { $archives = null; }

        return view('site-web.pages.historique', [
            'titre' => 'Historique - SYNEM',
            'events' => $events,
            'main' => isset($main) ? $main : null,
            'milestones' => isset($milestones) ? $milestones : null,
            'archives' => isset($archives) ? $archives : null,
        ]);
    }

    public function contact()
    {
        // Load contact data from DB if available, else use static fallbacks
        $infos = collect();
        $hours = collect();
        $faqs = collect();
        $map = null;
        $carousels = collect();

        try {
            if (class_exists(\App\Models\ContactInfo::class)) {
                $infos = \App\Models\ContactInfo::where('type', '!=', 'map')->orderBy('ordering')->get();
                $map = \App\Models\ContactInfo::where('type', 'map')->first();
            }
        } catch (\Throwable $e) {}

        try {
            if (class_exists(\App\Models\ContactHour::class)) {
                $hours = \App\Models\ContactHour::orderBy('ordering')->get();
            }
        } catch (\Throwable $e) {}

        try {
            if (class_exists(\App\Models\ContactFaq::class)) {
                $faqs = \App\Models\ContactFaq::orderBy('ordering')->get();
            }
        } catch (\Throwable $e) {}

        try {
            if (class_exists(\App\Models\ContactCarousel::class)) {
                $carousels = \App\Models\ContactCarousel::orderBy('ordering')->get();
            }
        } catch (\Throwable $e) {}

        return view('site-web.pages.contact', [
            'titre' => 'Contact - SYNEM',
            'infos' => $infos,
            'hours' => $hours,
            'faqs' => $faqs,
            'map' => $map,
            'carousels' => $carousels,
        ]);
    }
}