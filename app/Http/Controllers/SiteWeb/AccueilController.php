<?php

namespace App\Http\Controllers\SiteWeb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    public function index()
    {
        return view('site-web.accueil.index', [
            'titre' => 'Accueil - SYNEM',
            'description' => 'Syndicat National des Enseignants du Mali'
        ]);
    }
}