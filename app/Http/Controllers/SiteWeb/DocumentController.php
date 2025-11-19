<?php

namespace App\Http\Controllers\SiteWeb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch documents published for the homepage and allow filtering by type and search query
        $query = \App\Models\HomepageDocument::query();

        // Filter by file type (pdf, word, excel)
        if ($request->filled('type') && in_array($request->input('type'), ['pdf', 'word', 'excel'])) {
            $query->where('type', $request->input('type'));
        }

        // Simple title search
        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where('title', 'like', '%' . $q . '%');
        }

        $docs = $query->orderBy('created_at', 'desc')->paginate(12)->appends($request->only(['type', 'q']));
        return view('site-web.documents.index', compact('docs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
