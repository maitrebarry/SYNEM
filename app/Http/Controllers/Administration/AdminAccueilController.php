<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\HomepageContent;
use App\Models\HomepageDocument;
use App\Models\HomepageCarouselImage;

class AdminAccueilController extends Controller
{
    public function edit()
    {
        $content = HomepageContent::first();
        return view('administration.pages.accueil-edit', compact('content'));
    }

    public function update(Request $request)
    {
        $content = HomepageContent::firstOrNew([]);
        // Vérification rapide : si la requête dépasse post_max_size, PHP vide $_POST/$_FILES.
        // Dans ce cas on affiche une erreur claire au lieu de ne rien faire.
        try {
            $contentLength = 0;
            if (!empty($_SERVER['CONTENT_LENGTH'])) {
                $contentLength = (int) $_SERVER['CONTENT_LENGTH'];
            }
            $postMax = ini_get('post_max_size');
            // convert human-readable PHP size to bytes
            $mul = 1;
            $last = strtolower($postMax[strlen($postMax)-1]);
            $value = (int) trim($postMax);
            switch($last) {
                case 'g': $mul *= 1024;
                case 'm': $mul *= 1024;
                case 'k': $mul *= 1024;
            }
            $postMaxBytes = $value * $mul;
            if ($contentLength > 0 && $postMaxBytes > 0 && $contentLength > $postMaxBytes) {
                return redirect()->back()->withErrors(['upload_limit' => "La requête est trop volumineuse pour le serveur (post_max_size={$postMax}). Augmentez post_max_size/upload_max_filesize dans php.ini."])->withInput();
            }
        } catch (\Throwable $e) {
            // ne pas bloquer, on continue
        }
        // Log received file counts/sizes for debugging large uploads
        try {
            $carousel = $request->file('carousel_images', []);
            $docs = $request->file('new_document_file', []);
            $totalBytes = 0;
            foreach (array_merge((array)$carousel, (array)$docs) as $f) {
                if ($f instanceof \Illuminate\Http\UploadedFile) {
                    $totalBytes += $f->getSize() ?: 0;
                }
            }
            \Illuminate\Support\Facades\Log::info('Accueil update upload stats', [
                'carousel_count' => is_array($carousel) ? count($carousel) : 0,
                'docs_count' => is_array($docs) ? count($docs) : 0,
                'total_bytes' => $totalBytes,
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Erreur log upload stats: ' . $e->getMessage());
        }
        // Prevent empty submissions: require at least one non-empty input or at least one uploaded file
        $hasInput = false;
        $fieldsToCheck = [
            'carousel_title', 'carousel_subtitle', 'about_title', 'about_text',
            'news_title', 'news_items', 'documents_title'
        ];
        foreach ($fieldsToCheck as $f) {
            if (strlen(trim((string) $request->input($f, ''))) > 0) {
                $hasInput = true;
                break;
            }
        }
        // check new document titles/types
        if (! $hasInput) {
            $titles = $request->input('new_document_title', []);
            foreach ($titles as $t) {
                if (strlen(trim((string)$t)) > 0) { $hasInput = true; break; }
            }
        }
        // check files
        if (! $hasInput) {
            if ($request->hasFile('carousel_images') || $request->hasFile('about_image') || $request->hasFile('new_document_file')) {
                $hasInput = true;
            }
        }
        if (! $hasInput) {
            return redirect()->back()->withErrors(['empty' => 'Aucun changement détecté. Veuillez remplir au moins un champ ou sélectionner un fichier.'])->withInput();
        }

        // Validation: build dynamic rules so file inputs are only validated when present
        $rules = [
            'carousel_title' => 'nullable|string|max:255',
            'carousel_subtitle' => 'nullable|string|max:255',
            'carousel_images' => 'nullable|array',
            // 'carousel_images.*' will be added below if files present
            'about_title' => 'nullable|string|max:255',
            'about_text' => 'nullable|string',
            'about_image' => 'nullable|image|max:5120',
            'news_title' => 'nullable|string|max:255',
            'news_items' => 'nullable|string',
            'documents_title' => 'nullable|string|max:255',
            'new_document_file' => 'nullable|array',
            'new_document_title' => 'nullable|array',
            'new_document_title.*' => 'nullable|string|max:255',
            'new_document_type' => 'nullable|array',
            'new_document_type.*' => 'nullable|string|in:pdf,word,excel',
        ];

        // Validate non-file fields first
        \Illuminate\Support\Facades\Validator::make($request->all(), $rules)->validate();

        // Manual validation for uploaded files to avoid spurious index validation errors
        $fileErrors = new \Illuminate\Support\MessageBag();

        // Documents
        $allowedDocs = ['pdf','doc','docx','xls','xlsx'];
        $maxDocBytes = 10240 * 1024; // 10 MB
        $newDocs = $request->file('new_document_file', []);
        if (is_array($newDocs)) {
            foreach ($newDocs as $i => $f) {
                if ($f instanceof \Illuminate\Http\UploadedFile) {
                    $ext = strtolower($f->getClientOriginalExtension() ?: $f->extension());
                    if (!in_array($ext, $allowedDocs)) {
                        $fileErrors->add("new_document_file.$i", 'Le fichier doit être de type : ' . implode(', ', $allowedDocs) . '.');
                    }
                    if ($f->getSize() > $maxDocBytes) {
                        $fileErrors->add("new_document_file.$i", 'Le fichier est trop volumineux (max 10 Mo).');
                    }
                }
            }
        }

        // Carousel images
        $allowedImages = ['jpg','jpeg','png','gif','webp'];
        $maxImageBytes = 5120 * 1024; // 5 MB
        $carouselFiles = $request->file('carousel_images', []);
        if (is_array($carouselFiles)) {
            foreach ($carouselFiles as $i => $f) {
                if ($f instanceof \Illuminate\Http\UploadedFile) {
                    $ext = strtolower($f->getClientOriginalExtension() ?: $f->extension());
                    if (!in_array($ext, $allowedImages)) {
                        $fileErrors->add("carousel_images.$i", 'Image invalide. Formats acceptés : ' . implode(', ', $allowedImages) . '.');
                    }
                    if ($f->getSize() > $maxImageBytes) {
                        $fileErrors->add("carousel_images.$i", 'Image trop volumineuse (max 5 Mo).');
                    }
                }
            }
        }

        if ($fileErrors->any()) {
            return redirect()->back()->withErrors($fileErrors)->withInput();
        }

        // Note: Compte Rendu is managed via its own endpoint/modal (see updateCompteRendu)

        // Carrousel
        $content->carousel_title = $request->input('carousel_title');
        $content->carousel_subtitle = $request->input('carousel_subtitle');
        $content->save();

        // Upload des nouvelles images carrousel
        // Support per-image title/text fields: carousel_image_title[] and carousel_image_text[] (parallel arrays)
        $newTitles = $request->input('carousel_image_title', []);
        $newTexts = $request->input('carousel_image_text', []);
        if ($request->hasFile('carousel_images')) {
            foreach ($request->file('carousel_images') as $i => $img) {
                if (!($img instanceof \Illuminate\Http\UploadedFile)) continue;
                $path = $img->store('carousel', 'public');
                HomepageCarouselImage::create([
                    'homepage_content_id' => $content->id,
                    'file' => basename($path),
                    'title' => trim((string)($newTitles[$i] ?? '')) ?: null,
                    'text' => trim((string)($newTexts[$i] ?? '')) ?: null,
                ]);
            }
        }

        // À propos
        $content->about_title = $request->input('about_title');
        $content->about_text = $request->input('about_text');
        if ($request->hasFile('about_image')) {
            $content->about_image = $request->file('about_image')->store('homepage', 'public');
        }
        $content->save();

        // Actualités
        $content->news_title = $request->input('news_title');
        $content->news_items = $request->input('news_items');
        $content->save();

        // Documents
        $content->documents_title = $request->input('documents_title');
        $content->save();
        // Upload des nouveaux documents
        if ($request->hasFile('new_document_file')) {
            $titles = $request->input('new_document_title', []);
            $types = $request->input('new_document_type', []);
            foreach ($request->file('new_document_file') as $i => $file) {
                if ($file) {
                    $path = $file->store('documents', 'public');
                    HomepageDocument::create([
                        'homepage_content_id' => $content->id,
                        'title' => $titles[$i] ?? 'Document',
                        'type' => $types[$i] ?? 'pdf',
                        'file' => basename($path),
                    ]);
                }
            }
        }

        // clear old input so fields reflect saved DB values
        session()->forget('_old_input');
        return redirect()->route('administration.pages.accueil.edit')->with('success', 'Page d\'accueil mise à jour !');
    }

    /**
     * Separate endpoint to manage the "Compte Rendu" content and images.
     * This keeps it outside the main homepage edit form to avoid nested-form issues.
     */
    public function updateCompteRendu(Request $request)
    {
        $content = HomepageContent::firstOrNew([]);
        // If this is a delete-image action
        if ($request->has('delete_image')) {
            $file = $request->input('delete_image');
            $files = [];
            if (!empty($content->compte_rendu_images)) {
                $files = is_array($content->compte_rendu_images)
                    ? $content->compte_rendu_images
                    : (json_decode($content->compte_rendu_images, true) ?: []);
            }
            if (($key = array_search($file, $files)) !== false) {
                // delete physical file
                if (Storage::disk('public')->exists('compte_rendu/' . $file)) {
                    Storage::disk('public')->delete('compte_rendu/' . $file);
                }
                array_splice($files, $key, 1);
                $content->compte_rendu_images = json_encode(array_values($files));
                $content->save();
                return redirect()->route('administration.pages.accueil.edit')->with('success', 'Image supprimée du compte rendu.');
            }
            return redirect()->route('administration.pages.accueil.edit')->withErrors(['not_found' => 'Fichier introuvable.']);
        }

        $request->validate([
            'compte_rendu_title' => 'nullable|string|max:255',
            'compte_rendu_content' => 'nullable|string',
            'compte_rendu_images' => 'nullable|array',
        ]);

        $content->compte_rendu_title = $request->input('compte_rendu_title');
        $content->compte_rendu_content = $request->input('compte_rendu_content');

        // existing files array
        $existing = [];
        if (!empty($content->compte_rendu_images)) {
            $existing = is_array($content->compte_rendu_images) ? $content->compte_rendu_images : (json_decode($content->compte_rendu_images, true) ?: []);
        }

        if ($request->hasFile('compte_rendu_images')) {
            $allowedImages = ['jpg','jpeg','png','gif','webp'];
            $maxImageBytes = 5120 * 1024; // 5MB
            foreach ($request->file('compte_rendu_images') as $f) {
                if ($f instanceof \Illuminate\Http\UploadedFile) {
                    $ext = strtolower($f->getClientOriginalExtension() ?: $f->extension());
                    if (!in_array($ext, $allowedImages)) continue;
                    if ($f->getSize() > $maxImageBytes) continue;
                    $path = $f->store('compte_rendu', 'public');
                    $existing[] = basename($path);
                }
            }
        }

        $content->compte_rendu_images = json_encode(array_values($existing));
        $content->save();

        // Clear old input so fields reflect saved DB values
        session()->forget('_old_input');

        // Ensure only one success message is sent
        return redirect()->route('administration.pages.accueil.edit')
            ->with('success', 'Compte rendu mis à jour avec succès.');
    }

    public function deleteCompteRenduImage($id)
    {
        // deprecated: old implementation used a separate model. See updateCompteRendu handling.
        return redirect()->route('administration.pages.accueil.edit')->withErrors(['deprecated' => 'Opération non disponible. Utilisez la gestion dédiée du Compte Rendu.']);
    }

    public function deleteDocument($id)
    {
        $doc = HomepageDocument::findOrFail($id);
        // supprimer le fichier physique
        if ($doc->file && Storage::disk('public')->exists('documents/' . $doc->file)) {
            Storage::disk('public')->delete('documents/' . $doc->file);
        }
        $doc->delete();
        return redirect()->route('administration.pages.accueil.edit')->with('success', 'Document supprimé.');
    }

    public function updateDocument(Request $request, $id)
    {
        $doc = HomepageDocument::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:pdf,word,excel',
        ]);
        $doc->title = $request->input('title');
        $doc->type = $request->input('type');
        $doc->save();
        return redirect()->route('administration.pages.accueil.edit')->with('success', 'Document mis à jour.');
    }

    public function deleteCarouselImage($id)
    {
        $img = HomepageCarouselImage::findOrFail($id);
        if ($img->file && Storage::disk('public')->exists('carousel/' . $img->file)) {
            Storage::disk('public')->delete('carousel/' . $img->file);
        }
        $img->delete();
        return redirect()->route('administration.pages.accueil.edit')->with('success', 'Image du carrousel supprimée.');
    }

    /** Update metadata (title/text) for a single carousel image */
    public function updateCarouselImage(Request $request, $id)
    {
        $img = HomepageCarouselImage::findOrFail($id);
        $request->validate([
            'title' => 'nullable|string|max:255',
            'text' => 'nullable|string',
        ]);
        $img->title = $request->input('title') ?: null;
        $img->text = $request->input('text') ?: null;
        $img->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Métadonnées mises à jour.']);
        }

        return redirect()->route('administration.pages.accueil.edit')->with('success', 'Image mise à jour.');
    }

    public function deleteAboutImage()
    {
        $content = HomepageContent::first();
        if (!$content) {
            return redirect()->route('administration.pages.accueil.edit')->withErrors(['not_found' => 'Contenu introuvable.']);
        }
        if ($content->about_image && Storage::disk('public')->exists($content->about_image)) {
            Storage::disk('public')->delete($content->about_image);
        }
        $content->about_image = null;
        $content->save();
        return redirect()->route('administration.pages.accueil.edit')->with('success', 'Image de la section À propos supprimée.');
    }

    /**
     * Update only the carousel section (title/subtitle + images)
     */
    public function updateCarousel(Request $request)
    {
        // Log incoming request for debug: whether files arrived and their original names
        try {
            $received = [];
            $files = $request->file('carousel_images', []);
            if (is_array($files)) {
                foreach ($files as $f) {
                    if ($f instanceof \Illuminate\Http\UploadedFile) {
                        $received[] = $f->getClientOriginalName();
                    }
                }
            }
            \Illuminate\Support\Facades\Log::info('updateCarousel request received', [
                'has_files' => $request->hasFile('carousel_images'),
                'files_count' => is_array($files) ? count($files) : 0,
                'file_names' => $received,
                'full_url' => $request->fullUrl(),
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('updateCarousel logging failed: ' . $e->getMessage());
        }

        $content = HomepageContent::firstOrNew([]);
        $request->validate([
            'carousel_title' => 'nullable|string|max:255',
            'carousel_subtitle' => 'nullable|string|max:255',
            'carousel_images' => 'nullable|array',
        ]);

        $content->carousel_title = $request->input('carousel_title');
        $content->carousel_subtitle = $request->input('carousel_subtitle');
        $content->save();

        // handle image uploads
        $allowedImages = ['jpg','jpeg','png','gif','webp'];
        $maxImageBytes = 5120 * 1024; // 5MB
        $fileErrors = new \Illuminate\Support\MessageBag();
        if ($request->hasFile('carousel_images')) {
            $files = $request->file('carousel_images');
            foreach ($files as $i => $f) {
                if ($f instanceof \Illuminate\Http\UploadedFile) {
                    $ext = strtolower($f->getClientOriginalExtension() ?: $f->extension());
                    if (!in_array($ext, $allowedImages)) {
                        $fileErrors->add("carousel_images.$i", 'Image invalide.');
                        continue;
                    }
                    if ($f->getSize() > $maxImageBytes) {
                        $fileErrors->add("carousel_images.$i", 'Image trop volumineuse (max 5 Mo).');
                        continue;
                    }
                    $path = $f->store('carousel', 'public');
                    HomepageCarouselImage::create([
                        'homepage_content_id' => $content->id,
                        'file' => basename($path),
                    ]);
                }
            }
        }

        if ($fileErrors->any()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Erreurs de fichiers.', 'errors' => $fileErrors->all()], 422);
            }
            return redirect()->back()->withErrors($fileErrors)->withInput();
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Carrousel mis à jour.']);
        }

        return redirect()->route('administration.pages.accueil.edit')->with(['success' => 'Carrousel mis à jour.', 'success_section' => 'carousel']);
    }

    /** Update about section */
    public function updateAbout(Request $request)
    {
        $content = HomepageContent::firstOrNew([]);
        $request->validate([
            'about_title' => 'nullable|string|max:255',
            'about_text' => 'nullable|string',
            'about_image' => 'nullable|image|max:5120',
        ]);

        $content->about_title = $request->input('about_title');
        $content->about_text = $request->input('about_text');
        if ($request->hasFile('about_image')) {
            $content->about_image = $request->file('about_image')->store('homepage', 'public');
        }
        $content->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Section À propos mise à jour.']);
        }

        return redirect()->route('administration.pages.accueil.edit')->with(['success' => 'Section À propos mise à jour.', 'success_section' => 'about']);
    }

    /** Update news section */
    public function updateNews(Request $request)
    {
        $content = HomepageContent::firstOrNew([]);
        $request->validate([
            'news_title' => 'nullable|string|max:255',
            'news_items' => 'nullable|string',
        ]);

        $content->news_title = $request->input('news_title');
        $content->news_items = $request->input('news_items');
        $content->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Actualités mises à jour.']);
        }

        return redirect()->route('administration.pages.accueil.edit')->with(['success' => 'Actualités mises à jour.', 'success_section' => 'news']);
    }

    /** Update services section ("Nos Domaines d'Intervention") */
    public function updateServices(Request $request)
    {
        $content = HomepageContent::firstOrNew([]);
        $request->validate([
            'services_title' => 'nullable|string|max:255',
            'service_title' => 'nullable|array',
            'service_title.*' => 'nullable|string|max:255',
            'service_text' => 'nullable|array',
            'service_text.*' => 'nullable|string',
        ]);

        $content->services_title = $request->input('services_title');

        $titles = $request->input('service_title', []);
        $texts = $request->input('service_text', []);
        $items = [];
        $count = max(count($titles), count($texts));
        for ($i = 0; $i < $count; $i++) {
            $t = trim((string)($titles[$i] ?? ''));
            $tx = trim((string)($texts[$i] ?? ''));
            if ($t === '' && $tx === '') continue;
            $items[] = ['title' => $t, 'text' => $tx];
        }

        $content->services_items = count($items) ? json_encode(array_values($items)) : null;
        $content->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Section Nos Domaines d\'Intervention mise à jour.']);
        }

        return redirect()->route('administration.pages.accueil.edit')->with(['success' => 'Section Nos Domaines d\'Intervention mise à jour.', 'success_section' => 'services']);
    }

    /** Update documents section */
    public function updateDocuments(Request $request)
    {
        $content = HomepageContent::firstOrNew([]);
        $request->validate([
            'documents_title' => 'nullable|string|max:255',
            'new_document_title' => 'nullable|array',
            'new_document_title.*' => 'nullable|string|max:255',
            'new_document_type' => 'nullable|array',
            'new_document_type.*' => 'nullable|string|in:pdf,word,excel',
            'new_document_file' => 'nullable|array',
        ]);

        $content->documents_title = $request->input('documents_title');
        $content->save();

        // manual validation for documents files
        $allowedDocs = ['pdf','doc','docx','xls','xlsx'];
        $maxDocBytes = 10240 * 1024; // 10MB
        $fileErrors = new \Illuminate\Support\MessageBag();
        $newDocs = $request->file('new_document_file', []);
        if (is_array($newDocs)) {
            $titles = $request->input('new_document_title', []);
            $types = $request->input('new_document_type', []);
            foreach ($newDocs as $i => $f) {
                if ($f instanceof \Illuminate\Http\UploadedFile) {
                    $ext = strtolower($f->getClientOriginalExtension() ?: $f->extension());
                    if (!in_array($ext, $allowedDocs)) {
                        $fileErrors->add("new_document_file.$i", 'Format non pris en charge.');
                        continue;
                    }
                    if ($f->getSize() > $maxDocBytes) {
                        $fileErrors->add("new_document_file.$i", 'Fichier trop volumineux (max 10 Mo).');
                        continue;
                    }
                    $path = $f->store('documents', 'public');
                    HomepageDocument::create([
                        'homepage_content_id' => $content->id,
                        'title' => $titles[$i] ?? 'Document',
                        'type' => $types[$i] ?? 'pdf',
                        'file' => basename($path),
                    ]);
                }
            }
        }

        if ($fileErrors->any()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Erreurs de fichiers.', 'errors' => $fileErrors->all()], 422);
            }
            return redirect()->back()->withErrors($fileErrors)->withInput();
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Documents mis à jour.']);
        }

        return redirect()->route('administration.pages.accueil.edit')->with(['success' => 'Documents mis à jour.', 'success_section' => 'documents']);
    }
}
