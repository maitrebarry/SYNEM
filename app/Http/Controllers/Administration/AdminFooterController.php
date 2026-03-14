<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminFooterController extends Controller
{
    public function edit()
    {
        $footer = Footer::first() ?? new Footer();
        return view('administration.parametres.index', [
            'section_active' => 'footer',
            'contenu' => 'administration.parametres.sections.footer',
            'footer' => $footer
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'copyright_text' => 'nullable|string|max:500',
            'organization_name' => 'nullable|string|max:255',
            'newsletter_description' => 'nullable|string|max:500',
            'gallery_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'gallery_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'gallery_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $footer = Footer::first();
        if (!$footer) {
            $footer = new Footer();
        }

        $data = $request->only([
            'address', 'phone', 'email', 'facebook_url', 'twitter_url', 'linkedin_url',
            'copyright_text', 'organization_name', 'newsletter_description'
        ]);

        // Handle gallery images
        for ($i = 1; $i <= 3; $i++) {
            $field = 'gallery_image_' . $i;
            if ($request->hasFile($field)) {
                // Delete old image if exists
                if ($footer->$field && Storage::disk('public')->exists($footer->$field)) {
                    Storage::disk('public')->delete($footer->$field);
                }
                $data[$field] = $request->file($field)->store('footer-gallery', 'public');
            }
        }

        $footer->fill($data);
        $footer->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Footer mis à jour avec succès.']);
        }

        return redirect()->route('administration.parametres.footer')->with('success', 'Footer mis à jour avec succès.');
    }

    public function deleteGalleryImage(Request $request, $index)
    {
        $footer = Footer::first();
        if ($footer) {
            $field = 'gallery_image_' . $index;
            if ($footer->$field && Storage::disk('public')->exists($footer->$field)) {
                Storage::disk('public')->delete($footer->$field);
                $footer->$field = null;
                $footer->save();
            }
        }

        return response()->json(['success' => true]);
    }
}
