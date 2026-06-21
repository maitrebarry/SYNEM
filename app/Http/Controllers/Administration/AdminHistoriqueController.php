<?php
namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\HistoriqueEvent;
use App\Models\Milestone;
use App\Models\Archive;
use App\Models\HistoriqueMain;
use App\Models\PageCarouselSlide;

class AdminHistoriqueController extends Controller
{
    public function edit() {
        $events = [];
        $milestones = [];
        $archives = [];
        $main = null;
        $carouselSlides = collect();
        try {
            if (class_exists(HistoriqueEvent::class)) {
                $events = HistoriqueEvent::orderBy('ordering')->orderBy('id')->get();
            }
            if (class_exists(Milestone::class)) {
                $milestones = Milestone::orderBy('ordering')->orderBy('id')->get();
            }
            if (class_exists(Archive::class)) {
                $archives = Archive::orderBy('ordering')->orderBy('id')->get();
            }
            if (class_exists(HistoriqueMain::class)) {
                $main = HistoriqueMain::first();
            }
            $carouselSlides = PageCarouselSlide::where('page', 'historique')->orderBy('ordering')->orderBy('id')->get();
        } catch (\Throwable $e) {
            $events = [];
            $milestones = [];
            $archives = [];
        }

        return view('administration.pages.historique-edit', compact('events','milestones','archives','main', 'carouselSlides'));
    }
    public function updateMain(Request $request) {
        $data = $request->validate([
            'text' => 'nullable|string',
            'image' => 'nullable|file|image|max:10240',
        ]);

        $main = HistoriqueMain::first();
        if (!$main) $main = new HistoriqueMain();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.\-]/', '_', $file->getClientOriginalName());
            // store on the public disk under historique/
            Storage::disk('public')->putFileAs('historique', $file, $name);
            // delete old from public disk
            if ($main->image) {
                Storage::disk('public')->delete('historique/' . $main->image);
            }
            $main->image = $name;
        }

        if (array_key_exists('text', $data)) {
            $main->text = $data['text'];
        }

        $main->save();

        return response()->json(['success' => true, 'main' => $main]);
    }
    public function updateImage(Request $request) {
        return back()->with('success_section', 'image');
    }
    public function updateDocuments(Request $request) {
        return back()->with('success_section', 'documents');
    }
    public function deleteImage() {
        return back()->with('success_section', 'image');
    }
    public function deleteDocument($id) {
        return back()->with('success_section', 'documents');
    }

    // Create a new historique event
    public function store(Request $request)
    {
        $data = $request->validate([
            'year' => 'nullable|string|max:10',
            'title' => 'required|string|max:255',
            'text' => 'nullable|string',
            'image' => 'nullable|file|image|max:10240',
            'icon' => 'nullable|string|max:100',
            'ordering' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            Storage::disk('public')->putFileAs('historique', $file, $name);
            $data['image'] = $name;
        }

        $event = HistoriqueEvent::create($data);

        return response()->json(['success' => true, 'event' => $event]);
    }

    // Update an existing event
    public function update(Request $request, $id)
    {
        $event = HistoriqueEvent::findOrFail($id);
        $data = $request->validate([
            'year' => 'nullable|string|max:10',
            'title' => 'required|string|max:255',
            'text' => 'nullable|string',
            'image' => 'nullable|file|image|max:10240',
            'icon' => 'nullable|string|max:100',
            'ordering' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            // delete old
            if ($event->image) {
                Storage::disk('public')->delete('historique/' . $event->image);
            }
            $file = $request->file('image');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            Storage::disk('public')->putFileAs('historique', $file, $name);
            $data['image'] = $name;
        }

        $event->update($data);

        return response()->json(['success' => true, 'event' => $event]);
    }

    // Delete an event
    public function destroy($id)
    {
        $event = HistoriqueEvent::findOrFail($id);
        if ($event->image) {
            Storage::disk('public')->delete('historique/' . $event->image);
        }
        $event->delete();
        return response()->json(['success' => true]);
    }

    // Reorder events: expects `ordering` => [{id:1, ordering:0}, ...]
    public function reorder(Request $request)
    {
        $items = $request->input('ordering', []);
        foreach ($items as $it) {
            if (isset($it['id'])) {
                HistoriqueEvent::where('id', $it['id'])->update(['ordering' => intval($it['ordering'] ?? 0)]);
            }
        }
        return response()->json(['success' => true]);
    }

    // Milestones CRUD
    public function storeMilestone(Request $request)
    {
        $data = $request->validate([
            'number' => 'nullable|string|max:50',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'ordering' => 'nullable|integer',
        ]);
        $m = Milestone::create($data);
        return response()->json(['success' => true, 'milestone' => $m]);
    }

    public function updateMilestone(Request $request, $id)
    {
        $m = Milestone::findOrFail($id);
        $data = $request->validate([
            'number' => 'nullable|string|max:50',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'ordering' => 'nullable|integer',
        ]);
        $m->update($data);
        return response()->json(['success' => true, 'milestone' => $m]);
    }

    public function destroyMilestone($id)
    {
        $m = Milestone::findOrFail($id);
        $m->delete();
        return response()->json(['success' => true]);
    }

    public function reorderMilestones(Request $request)
    {
        $items = $request->input('ordering', []);
        foreach ($items as $it) {
            if (isset($it['id'])) {
                Milestone::where('id', $it['id'])->update(['ordering' => intval($it['ordering'] ?? 0)]);
            }
        }
        return response()->json(['success' => true]);
    }

    // Archives CRUD
    public function storeArchive(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'nullable|string',
            'image' => 'nullable|file|image|max:10240',
            'link' => 'nullable|url|max:255',
            'ordering' => 'nullable|integer',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            Storage::disk('public')->putFileAs('historique', $file, $name);
            $data['image'] = $name;
        }
        $a = Archive::create($data);
        return response()->json(['success' => true, 'archive' => $a]);
    }

    public function updateArchive(Request $request, $id)
    {
        $a = Archive::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'nullable|string',
            'image' => 'nullable|file|image|max:10240',
            'link' => 'nullable|url|max:255',
            'ordering' => 'nullable|integer',
        ]);
        if ($request->hasFile('image')) {
            if ($a->image) Storage::disk('public')->delete('historique/' . $a->image);
            $file = $request->file('image');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $file->getClientOriginalName());
            Storage::disk('public')->putFileAs('historique', $file, $name);
            $data['image'] = $name;
        }
        $a->update($data);
        return response()->json(['success' => true, 'archive' => $a]);
    }

    public function destroyArchive($id)
    {
        $a = Archive::findOrFail($id);
        if ($a->image) Storage::disk('public')->delete('historique/' . $a->image);
        $a->delete();
        return response()->json(['success' => true]);
    }

    public function reorderArchives(Request $request)
    {
        $items = $request->input('ordering', []);
        foreach ($items as $it) {
            if (isset($it['id'])) {
                Archive::where('id', $it['id'])->update(['ordering' => intval($it['ordering'] ?? 0)]);
            }
        }
        return response()->json(['success' => true]);
    }
}
