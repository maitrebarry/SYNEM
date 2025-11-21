<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Topbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminTopbarController extends Controller
{
    public function edit()
    {
        $topbar = Topbar::first() ?? new Topbar();
        return view('administration.parametres.index', [
            'section_active' => 'topbar',
            'contenu' => 'administration.parametres.sections.topbar',
            'topbar' => $topbar
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
        ]);

        $topbar = Topbar::first();
        if (!$topbar) {
            $topbar = new Topbar();
        }

        $topbar->fill($request->only([
            'phone', 'email', 'facebook_url', 'twitter_url', 'linkedin_url', 'instagram_url'
        ]));
        $topbar->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Topbar mis à jour avec succès.']);
        }

        return redirect()->route('administration.parametres.topbar')->with('success', 'Topbar mis à jour avec succès.');
    }
}
