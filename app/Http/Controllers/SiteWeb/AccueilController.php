<?php

namespace App\Http\Controllers\SiteWeb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function index()
    {
        $content = \App\Models\HomepageContent::first();
        return view('site-web.accueil.index', [
            'content' => $content,
            'titre' => 'Accueil - SYNEM',
            'description' => 'Syndicat National des Enseignants du Mali'
        ]);
    }
}