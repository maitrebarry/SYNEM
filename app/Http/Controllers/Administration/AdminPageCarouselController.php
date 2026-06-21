<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\PageCarouselSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminPageCarouselController extends Controller
{
    private const PAGES = ['a-propos', 'historique'];

    public function store(Request $request, string $page): RedirectResponse
    {
        $this->ensurePage($page);
        $data = $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'max:10240'],
            'title' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:1000'],
        ]);

        $nextOrder = (int) PageCarouselSlide::where('page', $page)->max('ordering');
        foreach ($request->file('images', []) as $image) {
            PageCarouselSlide::create([
                'page' => $page,
                'image' => $image->store('page-carousels/' . $page, 'public'),
                'title' => $data['title'] ?? null,
                'caption' => $data['caption'] ?? null,
                'ordering' => ++$nextOrder,
            ]);
        }

        return back()->with('success', 'Images du carrousel ajoutées.');
    }

    public function update(Request $request, PageCarouselSlide $slide): RedirectResponse
    {
        $data = $request->validate([
            'page' => ['required', Rule::in(self::PAGES)],
            'image' => ['nullable', 'image', 'max:5120'],
            'title' => ['nullable', 'string', 'max:255'],
            'caption' => ['nullable', 'string', 'max:1000'],
            'ordering' => ['required', 'integer', 'min:0'],
        ]);

        abort_unless($slide->page === $data['page'], 404);
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($slide->image);
            $data['image'] = $request->file('image')->store('page-carousels/' . $slide->page, 'public');
        } else {
            unset($data['image']);
        }
        unset($data['page']);
        $slide->update($data);

        return back()->with('success', 'Image du carrousel mise à jour.');
    }

    public function destroy(Request $request, PageCarouselSlide $slide): RedirectResponse
    {
        $request->validate(['page' => ['required', Rule::in(self::PAGES)]]);
        abort_unless($slide->page === $request->string('page')->toString(), 404);
        Storage::disk('public')->delete($slide->image);
        $slide->delete();

        return back()->with('success', 'Image du carrousel supprimée.');
    }

    private function ensurePage(string $page): void
    {
        abort_unless(in_array($page, self::PAGES, true), 404);
    }
}
