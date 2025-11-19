<?php
namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\MissionPage;
use App\Models\MissionHeaderImage;
use App\Models\MissionDocument;
use App\Models\MissionItem;
use App\Models\MissionValue;

class AdminMissionController extends Controller
{
    public function edit() {
        $page = MissionPage::first();
        if (! $page) {
            $page = MissionPage::create([]);
        }
        return view('administration.pages.mission-edit', ['page' => $page]);
    }

    public function updateMain(Request $request) {
        $page = MissionPage::firstOrCreate([]);
        $request->validate(['mission_main' => 'nullable|string']);
        $page->mission_main = $request->input('mission_main');
        $page->save();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Mission principale mise à jour.']);
        }
        return redirect()->route('administration.pages.mission.edit')->with('success', 'Mission principale mise à jour.');
    }

    public function updateImage(Request $request) {
        $page = MissionPage::firstOrCreate([]);
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $orig = is_object($img) && method_exists($img, 'getClientOriginalName') ? $img->getClientOriginalName() : null;
            if ($orig) {
                // allow images up to 10 MB
                $request->validate(['image' => 'image|max:10240']);
                // delete old
                if ($page->mission_image && Storage::disk('public')->exists($page->mission_image)) {
                    Storage::disk('public')->delete($page->mission_image);
                }
                $path = $img->store('mission', 'public');
                $page->mission_image = $path;
                $page->save();
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Image de la mission mise à jour.']);
                }
                return redirect()->route('administration.pages.mission.edit')->with('success', 'Image de la mission mise à jour.');
            }
            // treat as no-file provided
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Aucun fichier fourni.'], 400);
            }
            return redirect()->route('administration.pages.mission.edit')->withErrors(['empty' => 'Aucun fichier fourni.']);
        }
        return redirect()->route('administration.pages.mission.edit')->withErrors(['empty' => 'Aucun fichier fourni.']);
    }

    public function updateDocuments(Request $request) {
        $page = MissionPage::firstOrCreate([]);

        // delete_file action
        if ($request->filled('delete_file')) {
            $file = $request->input('delete_file');
            $doc = MissionDocument::where('mission_page_id', $page->id)->where('file', $file)->first();
            if ($doc) {
                if (Storage::disk('public')->exists('mission_documents/' . $doc->file)) {
                    Storage::disk('public')->delete('mission_documents/' . $doc->file);
                }
                $doc->delete();
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Document supprimé.']);
                }
                return redirect()->route('administration.pages.mission.edit')->with('success', 'Document supprimé.');
            }
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Document introuvable.'], 404);
            }
            return redirect()->route('administration.pages.mission.edit')->withErrors(['not_found' => 'Document introuvable.']);
        }

        // upload new documents
        if ($request->hasFile('documents')) {
            $files = $request->file('documents');
            foreach ($files as $f) {
                if (!($f instanceof \Illuminate\Http\UploadedFile)) continue;
                $path = $f->store('mission_documents', 'public');
                MissionDocument::create([
                    'mission_page_id' => $page->id,
                    'title' => $f->getClientOriginalName(),
                    'type' => strtolower($f->getClientOriginalExtension() ?: ''),
                    'file' => basename($path),
                ]);
            }
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Documents ajoutés.']);
            }
            return redirect()->route('administration.pages.mission.edit')->with('success', 'Documents ajoutés.');
        }

        return redirect()->route('administration.pages.mission.edit')->withErrors(['empty' => 'Aucune donnée fournie.']);
    }
    /**
     * Handle header image add/edit/delete and caption updates.
     */
    public function updateHeader(Request $request)
    {
        $page = MissionPage::firstOrCreate([]);

        // delete file action
        if ($request->filled('delete_file')) {
            $file = $request->input('delete_file');
            $img = MissionHeaderImage::where('mission_page_id', $page->id)->where('file', $file)->first();
            if ($img) {
                if (Storage::disk('public')->exists('mission_header/' . $img->file)) {
                    Storage::disk('public')->delete('mission_header/' . $img->file);
                }
                $img->delete();
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Image supprimée.']);
                }
                return redirect()->route('administration.pages.mission.edit')->with('success', 'Image supprimée.');
            }
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Fichier introuvable.'], 404);
            }
            return redirect()->route('administration.pages.mission.edit')->withErrors(['not_found' => 'Fichier introuvable.']);
        }

        // update caption for existing file
        if ($request->filled('existing_file') && $request->filled('caption') && ! $request->hasFile('header_image')) {
            $file = $request->input('existing_file');
            $img = MissionHeaderImage::where('mission_page_id', $page->id)->where('file', $file)->first();
            if ($img) {
                $img->caption = $request->input('caption');
                $img->save();
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Légende mise à jour.']);
                }
                return redirect()->route('administration.pages.mission.edit')->with('success', 'Légende mise à jour.');
            }
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Image introuvable.'], 404);
            }
            return redirect()->route('administration.pages.mission.edit')->withErrors(['not_found' => 'Image introuvable.']);
        }

        // upload new header image (optional caption)
        if ($request->hasFile('header_image')) {
            $f = $request->file('header_image');
            $origName = is_object($f) && method_exists($f, 'getClientOriginalName') ? $f->getClientOriginalName() : null;
            if ($origName) {
                // allow header images up to 10 MB
                $request->validate(['header_image' => 'image|max:10240', 'caption' => 'nullable|string|max:255']);
                $path = $f->store('mission_header', 'public');
                MissionHeaderImage::create([
                    'mission_page_id' => $page->id,
                    'file' => basename($path),
                    'caption' => $request->input('caption') ?: null,
                ]);
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Image ajoutée.']);
                }
                return redirect()->route('administration.pages.mission.edit')->with('success', 'Image ajoutée.');
            }
        }

        // nothing to do — log for debugging then respond
        Log::info('AdminMissionController@updateHeader - empty request', ['all' => $request->all(), 'files' => array_keys($request->files->all())]);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Aucune donnée fournie.'], 400);
        }
        return redirect()->route('administration.pages.mission.edit')->withErrors(['empty' => 'Aucune donnée fournie.']);
    }

    /**
     * Update missions list (add/edit/delete by index)
     */
    public function updateItems(Request $request)
    {
        $page = MissionPage::firstOrCreate([]);

        $items = MissionItem::where('mission_page_id', $page->id)->orderBy('ordering')->orderBy('id')->get()->values();

        // delete by index
        if ($request->filled('delete_index')) {
            $idx = (int) $request->input('delete_index');
            if (isset($items[$idx])) {
                $items[$idx]->delete();
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Élément supprimé.']);
                }
                return redirect()->route('administration.pages.mission.edit')->with('success', 'Élément supprimé.');
            }
            return $request->ajax() || $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Index introuvable.'], 404)
                : redirect()->route('administration.pages.mission.edit')->withErrors(['not_found' => 'Index introuvable.']);
        }

        $request->validate([
            'icon' => 'nullable|string|max:191',
            'title' => 'nullable|string|max:255',
            'text' => 'nullable|string',
            'item_index' => 'nullable|numeric',
        ]);

        if ($request->filled('item_index')) {
            $idx = (int) $request->input('item_index');
            if (isset($items[$idx])) {
                $item = $items[$idx];
                $item->icon = $request->input('icon');
                $item->title = $request->input('title');
                $item->text = $request->input('text');
                $item->save();
            } else {
                MissionItem::create([
                    'mission_page_id' => $page->id,
                    'icon' => $request->input('icon'),
                    'title' => $request->input('title'),
                    'text' => $request->input('text'),
                ]);
            }
        } else {
            MissionItem::create([
                'mission_page_id' => $page->id,
                'icon' => $request->input('icon'),
                'title' => $request->input('title'),
                'text' => $request->input('text'),
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Missions mises à jour.']);
        }
        return redirect()->route('administration.pages.mission.edit')->with('success', 'Missions mises à jour.');
    }

    /**
     * Update values list (similar to missions)
     */
    public function updateValues(Request $request)
    {
        $page = MissionPage::firstOrCreate([]);
        $items = MissionValue::where('mission_page_id', $page->id)->orderBy('ordering')->orderBy('id')->get()->values();

        if ($request->filled('delete_index')) {
            $idx = (int) $request->input('delete_index');
            if (isset($items[$idx])) {
                $items[$idx]->delete();
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Élément supprimé.']);
                }
                return redirect()->route('administration.pages.mission.edit')->with('success', 'Élément supprimé.');
            }
            return $request->ajax() || $request->wantsJson()
                ? response()->json(['success' => false, 'message' => 'Index introuvable.'], 404)
                : redirect()->route('administration.pages.mission.edit')->withErrors(['not_found' => 'Index introuvable.']);
        }

        $request->validate([
            'icon' => 'nullable|string|max:191',
            'title' => 'nullable|string|max:255',
            'text' => 'nullable|string',
            'value_index' => 'nullable|numeric',
        ]);

        if ($request->filled('value_index')) {
            $idx = (int) $request->input('value_index');
            if (isset($items[$idx])) {
                $item = $items[$idx];
                $item->icon = $request->input('icon');
                $item->title = $request->input('title');
                $item->text = $request->input('text');
                $item->save();
            } else {
                MissionValue::create([
                    'mission_page_id' => $page->id,
                    'icon' => $request->input('icon'),
                    'title' => $request->input('title'),
                    'text' => $request->input('text'),
                ]);
            }
        } else {
            MissionValue::create([
                'mission_page_id' => $page->id,
                'icon' => $request->input('icon'),
                'title' => $request->input('title'),
                'text' => $request->input('text'),
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Valeurs mises à jour.']);
        }
        return redirect()->route('administration.pages.mission.edit')->with('success', 'Valeurs mises à jour.');
    }

    /**
     * Update CTA block
     */
    public function updateCta(Request $request)
    {
        $page = MissionPage::firstOrCreate([]);
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:1024',
        ]);
        $cta = [
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'button_text' => $request->input('button_text'),
            'link' => $request->input('button_link'),
        ];
        $page->mission_cta = $cta;
        $page->save();
        return $request->ajax() || $request->wantsJson()
            ? response()->json(['success' => true, 'message' => 'CTA mise à jour.'])
            : redirect()->route('administration.pages.mission.edit')->with('success', 'CTA mise à jour.');
    }
    public function deleteImage()
    {
        $page = MissionPage::first();
        if ($page && $page->mission_image && Storage::disk('public')->exists($page->mission_image)) {
            Storage::disk('public')->delete($page->mission_image);
        }
        if ($page) {
            $page->mission_image = null;
            $page->save();
        }
        return redirect()->route('administration.pages.mission.edit')->with('success', 'Image supprimée.');
    }

    public function deleteDocument($id)
    {
        $doc = MissionDocument::find($id);
        if ($doc) {
            if ($doc->file && Storage::disk('public')->exists('mission_documents/' . $doc->file)) {
                Storage::disk('public')->delete('mission_documents/' . $doc->file);
            }
            $doc->delete();
        }
        return redirect()->route('administration.pages.mission.edit')->with('success', 'Document supprimé.');
    }
}
