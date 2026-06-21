<?php
namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\PageCarouselSlide;

class AdminAproposController extends Controller
{
    public function edit() {
        $about = \App\Models\AboutPageContent::first();
        $carouselSlides = PageCarouselSlide::where('page', 'a-propos')->orderBy('ordering')->orderBy('id')->get();
        return view('administration.pages.a-propos-edit', compact('about', 'carouselSlides'));
    }
    public function updatePresentation(Request $request) {
        $about = \App\Models\AboutPageContent::firstOrNew([]);
        $about->about_text = $request->input('about_text', '');
        $about->save();
        if ($request->wantsJson()) return response()->json(['success' => true]);
        return back()->with('success_section', 'presentation');
    }
    public function updateMission(Request $request) {
        // Logique d'enregistrement du texte de mission
        return back()->with('success_section', 'mission');
    }
    public function updateImage(Request $request) {
        $about = \App\Models\AboutPageContent::firstOrNew([]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file && $file->isValid()) {
                // delete old image if exists
                if (!empty($about->image)) {
                    $old = storage_path('app/public/about/' . $about->image);
                    if (file_exists($old)) @unlink($old);
                }
                $path = $file->store('about', 'public');
                $about->image = basename($path);
                $about->save();
                if ($request->wantsJson()) return response()->json(['success' => true, 'image' => asset('storage/about/' . $about->image)]);
                return back()->with('success_section', 'image');
            }
        }
        if ($request->wantsJson()) return response()->json(['error' => 'Fichier invalide'], 422);
        return back()->with('error', 'Fichier invalide');
    }
    public function updateDocuments(Request $request) {
        // Logique d'enregistrement des documents
        return back()->with('success_section', 'documents');
    }
    public function deleteImage() {
        $about = \App\Models\AboutPageContent::first();
        if (!$about || empty($about->image)) {
            if (request()->wantsJson()) return response()->json(['error' => 'Aucune image'], 404);
            return back()->with('error', 'Aucune image');
        }
        $path = storage_path('app/public/about/' . $about->image);
        if (file_exists($path)) @unlink($path);
        $about->image = null;
        $about->save();
        if (request()->wantsJson()) return response()->json(['success' => true]);
        return back()->with('success_section', 'image');
    }
    public function deleteDocument($id) {
        // Logique de suppression d'un document
        return back()->with('success_section', 'documents');
    }
    public function update(Request $request)
    {
        Log::info('[AdminAproposController@update] incoming', ['inputs' => array_keys($request->all()), 'has_files' => count($request->files->all())]);
        $about = \App\Models\AboutPageContent::firstOrNew([]);
        $about->about_text = $request->input('about_text');
        $about->stats_members = $request->input('stats_members');
        $about->stats_years = $request->input('stats_years');
        $about->stats_regions = $request->input('stats_regions');
        $about->stats_trainings = $request->input('stats_trainings');

        // Timeline: append newly submitted entries to existing ones (so existing DB rows shown in table are preserved)
        $submittedTimeline = $request->input('timeline', []);
        $existingTimeline = $about->timeline ?? [];
        $about->timeline = array_merge(array_values($existingTimeline), array_values($submittedTimeline));

        // Process team entries and handle uploaded photos
        // Team: process new members and append to existing members
        $teamInput = $request->input('team', []);
        $processedTeam = [];
        foreach ($teamInput as $i => $member) {
            $name = $member['name'] ?? null;
            $role = $member['role'] ?? null;
            $photoName = $member['photo'] ?? null;

            // Check for uploaded file corresponding to this team index
            if ($request->hasFile("team.$i.photo")) {
                $file = $request->file("team.$i.photo");
                if ($file && $file->isValid()) {
                    $path = $file->store('team', 'public');
                    $photoName = basename($path);
                }
            }

            $processedTeam[] = [
                'name' => $name,
                'role' => $role,
                'photo' => $photoName,
            ];
        }
        $existingTeam = $about->team ?? [];
        $about->team = array_merge(array_values($existingTeam), array_values($processedTeam));

        // Main image handling (page hero)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file && $file->isValid()) {
                $path = $file->store('about', 'public');
                $about->image = basename($path);
                Log::info('[AdminAproposController@update] stored image', ['path' => $path]);
            } else {
                Log::warning('[AdminAproposController@update] image upload invalid');
            }
        }

        $about->save();
        return redirect()->route('administration.pages.a-propos.edit')->with('success', 'Page À propos mise à jour !');
    }

    // Delete a timeline entry by index
    public function deleteTimeline(Request $request, $index)
    {
        $about = \App\Models\AboutPageContent::first();
        if (!$about) {
            if ($request->wantsJson()) return response()->json(['error' => 'Aucun contenu trouvé'], 404);
            return back()->with('error', 'Aucun contenu trouvé');
        }
        $timeline = $about->timeline ?? [];
        if (isset($timeline[$index])) {
            array_splice($timeline, $index, 1);
            $about->timeline = $timeline;
            $about->save();
        }
        if ($request->wantsJson()) return response()->json(['success' => true]);
        return back()->with('success_section', 'timeline');
    }

    // Update a timeline entry by index (expects year,title,text via request)
    public function updateTimelineEntry(Request $request, $index)
    {
        $about = \App\Models\AboutPageContent::firstOrNew([]);
        $timeline = $about->timeline ?? [];
        if (!isset($timeline[$index])) {
            if ($request->wantsJson()) return response()->json(['error' => 'Entrée introuvable'], 404);
            return back()->with('error', 'Entrée introuvable');
        }
        $timeline[$index]['year'] = $request->input('year');
        $timeline[$index]['title'] = $request->input('title');
        $timeline[$index]['text'] = $request->input('text');
        $about->timeline = $timeline;
        $about->save();
        if ($request->wantsJson()) return response()->json(['success' => true]);
        return back()->with('success_section', 'timeline');
    }

    // Create a new timeline entry (AJAX)
    public function createTimelineEntry(Request $request)
    {
        $about = \App\Models\AboutPageContent::firstOrNew([]);
        $timeline = $about->timeline ?? [];
        $entry = [
            'year' => $request->input('year', ''),
            'title' => $request->input('title', ''),
            'text' => $request->input('text', ''),
        ];
        $timeline[] = $entry;
        $about->timeline = $timeline;
        $about->save();
        return response()->json(['success' => true, 'entry' => $entry, 'index' => count($timeline)-1]);
    }

    // Delete a team member by index and remove associated photo file
    public function deleteTeam(Request $request, $index)
    {
        $about = \App\Models\AboutPageContent::first();
        if (!$about) {
            if ($request->wantsJson()) return response()->json(['error' => 'Aucun contenu trouvé'], 404);
            return back()->with('error', 'Aucun contenu trouvé');
        }
        $team = $about->team ?? [];
        if (isset($team[$index])) {
            $member = $team[$index];
            // remove file if exists
            if (!empty($member['photo'])) {
                $path = storage_path('app/public/team/' . $member['photo']);
                if (file_exists($path)) @unlink($path);
            }
            array_splice($team, $index, 1);
            $about->team = $team;
            $about->save();
        }
        if ($request->wantsJson()) return response()->json(['success' => true]);
        return back()->with('success_section', 'team');
    }

    // Update a team member entry by index (allows new photo upload)
    public function updateTeamEntry(Request $request, $index)
    {
        $about = \App\Models\AboutPageContent::firstOrNew([]);
        $team = $about->team ?? [];
        if (!isset($team[$index])) {
            if ($request->wantsJson()) return response()->json(['error' => 'Membre introuvable'], 404);
            return back()->with('error', 'Membre introuvable');
        }
        $member = $team[$index];
        $member['name'] = $request->input('name', $member['name'] ?? '');
        $member['role'] = $request->input('role', $member['role'] ?? '');
        // handle photo replacement
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if ($file && $file->isValid()) {
                // delete old
                if (!empty($member['photo'])) {
                    $old = storage_path('app/public/team/' . $member['photo']);
                    if (file_exists($old)) @unlink($old);
                }
                $path = $file->store('team', 'public');
                $member['photo'] = basename($path);
            }
        }
        $team[$index] = $member;
        $about->team = $team;
        $about->save();
        if ($request->wantsJson()) return response()->json(['success' => true]);
        return back()->with('success_section', 'team');
    }

    // Create a new team member (AJAX)
    public function createTeamEntry(Request $request)
    {
        $about = \App\Models\AboutPageContent::firstOrNew([]);
        $team = $about->team ?? [];
        $member = [
            'name' => $request->input('name', ''),
            'role' => $request->input('role', ''),
            'photo' => null,
        ];
        // handle photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if ($file && $file->isValid()) {
                $path = $file->store('team', 'public');
                $member['photo'] = basename($path);
            }
        }
        $team[] = $member;
        $about->team = $team;
        $about->save();
        return response()->json(['success' => true, 'member' => $member, 'index' => count($team)-1]);
    }

    // Update stats independently (AJAX)
    public function updateStats(Request $request)
    {
        $about = \App\Models\AboutPageContent::firstOrNew([]);
        $about->stats_members = $request->input('stats_members', $about->stats_members);
        $about->stats_years = $request->input('stats_years', $about->stats_years);
        $about->stats_regions = $request->input('stats_regions', $about->stats_regions);
        $about->stats_trainings = $request->input('stats_trainings', $about->stats_trainings);
        $about->save();
        return response()->json(['success' => true]);
    }
}
