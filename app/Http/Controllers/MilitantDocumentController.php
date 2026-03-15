<?php

namespace App\Http\Controllers;

use App\Models\MemberCardCampaign;
use App\Models\Militant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MilitantDocumentController extends Controller
{
    public function accessForm()
    {
        return view('site-web.militant-documents.access');
    }

    public function verifyAccess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'card_number' => 'required|string',
        ]);

        $militant = Militant::where('email', $request->email)
                           ->where('n_cartes_syndicale', $request->card_number)
                           ->where('status', 'approved')
                           ->first();

        if (!$militant) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Informations incorrectes ou compte non approuvé.'
                ], 422);
            }
            return back()->withErrors(['access' => 'Informations incorrectes ou compte non approuvé.']);
        }

        // Store militant info in session for document access
        session(['verified_militant' => $militant->id]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Vérification réussie. Redirection en cours...',
                'redirect' => route('militant.documents.index')
            ]);
        }

        return redirect()->route('militant.documents.index');
    }

    public function index()
    {
        // Check if militant is verified
        if (!session('verified_militant')) {
            return redirect()->route('militant.documents.access')->withErrors(['access' => 'Veuillez vous identifier d\'abord.']);
        }

        $militant = Militant::find(session('verified_militant'));
        if (!$militant || $militant->status !== 'approved') {
            session()->forget('verified_militant');
            return redirect()->route('militant.documents.access')->withErrors(['access' => 'Accès non autorisé.']);
        }

        // Get reserved documents (you can customize this logic)
        $documents = $this->getReservedDocuments();

        $messages = $militant->messages;

        $activeMemberCardCampaign = MemberCardCampaign::query()
            ->active()
            ->latest('sent_at')
            ->first();

        $memberCardSubmission = $activeMemberCardCampaign
            ? $militant->cardPhotoSubmissions()
                ->where('member_card_campaign_id', $activeMemberCardCampaign->id)
                ->first()
            : $militant->latestCardPhotoSubmission;

        return view('site-web.militant-documents.index', compact(
            'militant',
            'documents',
            'messages',
            'activeMemberCardCampaign',
            'memberCardSubmission'
        ));
    }

    public function download(Request $request, $filename)
    {
        // Check if militant is verified
        if (!session('verified_militant')) {
            abort(403, 'Accès non autorisé');
        }

        $militant = Militant::find(session('verified_militant'));
        if (!$militant || $militant->status !== 'approved') {
            abort(403, 'Accès non autorisé');
        }

        // Check if file exists and is in reserved documents
        $reservedDocuments = $this->getReservedDocuments();
        $document = collect($reservedDocuments)->firstWhere('filename', $filename);

        if (!$document) {
            abort(404, 'Document non trouvé');
        }

        $filePath = storage_path('app/public/documents/' . $filename);

        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }

        return response()->download($filePath);
    }

    public function logout()
    {
        session()->forget('verified_militant');
        return redirect()->route('accueil')->with('success', 'Vous avez été déconnecté.');
    }

    public function testCategories()
    {
        $documents = $this->getReservedDocuments();
        return response()->json($documents);
    }

    private function getReservedDocuments()
    {
        // Get all published documents from the database
        $homepageDocuments = \App\Models\HomepageDocument::with('homepageContent')
            ->orderBy('created_at', 'desc')
            ->get();

        $documents = [];

        foreach ($homepageDocuments as $doc) {
            // Get file size if file exists
            $filePath = storage_path('app/public/documents/' . $doc->file);
            $fileSize = 'N/A';
            if (file_exists($filePath)) {
                $bytes = filesize($filePath);
                $fileSize = $this->formatBytes($bytes);
            }

            // Determine category based on title or content
            $category = $this->categorizeDocument($doc->title, $doc->type);

            $documents[] = [
                'filename' => $doc->file,
                'title' => $doc->title,
                'description' => $doc->homepageContent ? 'Document officiel du SYNEM' : 'Document administratif',
                'size' => $fileSize,
                'type' => strtoupper($doc->type),
                'file_path' => $doc->file,
                'category' => $category
            ];
        }

        // If no documents in database, return some default reserved documents
        if (empty($documents)) {
            return [
                [
                    'filename' => 'statuts_synem_2024.pdf',
                    'title' => 'Statuts du SYNEM 2024',
                    'description' => 'Document officiel des statuts de l\'organisation',
                    'size' => '2.5 MB',
                    'type' => 'PDF',
                    'file_path' => 'statuts_synem_2024.pdf'
                ],
                [
                    'filename' => 'reglement_interieur_synem_2024.pdf',
                    'title' => 'Règlement Intérieur SYNEM 2024',
                    'description' => 'Règlement intérieur du SYNEM',
                    'size' => '1.8 MB',
                    'type' => 'PDF',
                    'file_path' => 'reglement_interieur_synem_2024.pdf'
                ],
                [
                    'filename' => 'procedures_electorales_synem_2024.pdf',
                    'title' => 'Procédures Électorales SYNEM 2024',
                    'description' => 'Procédures électorales du SYNEM',
                    'size' => '3.2 MB',
                    'type' => 'PDF',
                    'file_path' => 'procedures_electorales_synem_2024.pdf'
                ]
            ];
        }

        return $documents;
    }

    private function categorizeDocument($title, $type)
    {
        $titleLower = strtolower($title);

        // Administrative documents
        if (strpos($titleLower, 'affectation') !== false ||
            strpos($titleLower, 'autorisation') !== false ||
            strpos($titleLower, 'hiérarchisation') !== false) {
            return 'administratif';
        }

        // Formation documents
        if (strpos($titleLower, 'formation') !== false ||
            strpos($titleLower, 'conge de formation') !== false ||
            strpos($titleLower, 'manuel') !== false) {
            return 'formation';
        }

        // Activity/Reports documents
        if (strpos($titleLower, 'rappel') !== false ||
            strpos($titleLower, 'activite') !== false ||
            strpos($titleLower, 'rapport') !== false) {
            return 'activite';
        }

        // Default category based on type
        switch (strtolower($type)) {
            case 'pdf':
                return 'document';
            case 'doc':
            case 'docx':
                return 'word';
            case 'xls':
            case 'xlsx':
                return 'excel';
            default:
                return 'divers';
        }
    }

    private function formatBytes($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}
