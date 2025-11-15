<?php

namespace App\Http\Controllers\SiteWeb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function aPropos()
    {
        return view('site-web.pages.a-propos', [
            'titre' => 'À propos - SYNEM'
        ]);
    }

    public function mission()
    {
        return view('site-web.pages.mission', [
            'titre' => 'Notre mission - SYNEM'
        ]);
    }

    public function historique()
    {
        return view('site-web.pages.historique', [
            'titre' => 'Historique - SYNEM'
        ]);
    }

    public function contact()
    {
        return view('site-web.pages.contact', [
            'titre' => 'Contact - SYNEM'
        ]);
    }
}