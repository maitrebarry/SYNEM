<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Lettre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class LettreController extends Controller
{
    public function index()
    {
        $lettres = Lettre::with('auteur')->latest()->paginate(15);
        return view('administration.lettres.index', compact('lettres'));
    }

    public function create()
    {
        $nextNumero  = $this->genererNumero();
        $currentUser = Auth::user();
        $signataires = User::where('is_active', true)
            ->where('role', 'admin')
            ->select('id', 'name', 'fonction')
            ->get();
        return view('administration.lettres.create', compact('nextNumero', 'currentUser', 'signataires'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'numero'             => 'required|string|max:60|unique:lettres',
            'date_lettre'        => 'required|date',
            'destinataire'       => 'required|string',
            'objet'              => 'required|string|max:500',
            'corps'              => 'required|string',
            'ampliations'        => 'nullable|string',
            'signataire'         => 'required|string|max:200',
            'fonction_signataire'=> 'required|string|max:200',
            'cachet'             => 'nullable|image|max:2048',
            'signature_fichier'  => 'nullable|image|max:2048',
            'signature_base64'   => 'nullable|string',
            'pieces_jointes.*'   => 'nullable|file|max:5120',
            'est_publiee'        => 'boolean',
            'est_telechargeable' => 'boolean',
        ]);

        // Sceau électronique (cachet)
        $cachehtPath = null;
        if ($request->hasFile('cachet')) {
            $cachehtPath = $request->file('cachet')->store('lettres/cachets', 'public');
        }

        // Signature électronique : canvas (base64) prioritaire, sinon fichier importé
        $signaturePath = null;
        if ($request->filled('signature_base64')) {
            $b64 = preg_replace('/^data:image\/\w+;base64,/', '', $request->signature_base64);
            $decoded = base64_decode($b64);
            $filename = 'lettres/signatures/' . uniqid() . '.png';
            Storage::disk('public')->put($filename, $decoded);
            $signaturePath = $filename;
        } elseif ($request->hasFile('signature_fichier')) {
            $signaturePath = $request->file('signature_fichier')->store('lettres/signatures', 'public');
        }

        // Pièces jointes
        $pj = [];
        if ($request->hasFile('pieces_jointes')) {
            foreach ($request->file('pieces_jointes') as $file) {
                $path = $file->store('lettres/pj', 'public');
                $pj[] = ['nom' => $file->getClientOriginalName(), 'path' => $path];
            }
        }

        // Ampliations : convertir les lignes en tableau
        $ampliations = [];
        if (!empty($data['ampliations'])) {
            $ampliations = array_filter(array_map('trim', explode("\n", $data['ampliations'])));
        }

        $lettre = Lettre::create([
            'numero'             => $data['numero'],
            'date_lettre'        => $data['date_lettre'],
            'destinataire'       => $data['destinataire'],
            'objet'              => $data['objet'],
            'corps'              => $data['corps'],
            'ampliations'        => array_values($ampliations),
            'signataire'         => $data['signataire'],
            'fonction_signataire'=> $data['fonction_signataire'],
            'cachet_path'        => $cachehtPath,
            'signature_path'     => $signaturePath,
            'pieces_jointes'     => $pj ?: null,
            'est_publiee'        => $request->boolean('est_publiee'),
            'est_telechargeable' => $request->boolean('est_telechargeable', true),
            'created_by'         => Auth::id(),
        ]);

        return redirect()->route('administration.lettres.show', $lettre)
            ->with('success', 'Lettre créée avec succès.');
    }

    public function show(Lettre $lettre)
    {
        return view('administration.lettres.show', compact('lettre'));
    }

    public function edit(Lettre $lettre)
    {
        $currentUser = Auth::user();
        $signataires = User::where('is_active', true)
            ->where('role', 'admin')
            ->select('id', 'name', 'fonction')
            ->get();
        return view('administration.lettres.edit', compact('lettre', 'currentUser', 'signataires'));
    }

    public function update(Request $request, Lettre $lettre)
    {
        $data = $request->validate([
            'numero'             => 'required|string|max:60|unique:lettres,numero,' . $lettre->id,
            'date_lettre'        => 'required|date',
            'destinataire'       => 'required|string',
            'objet'              => 'required|string|max:500',
            'corps'              => 'required|string',
            'ampliations'        => 'nullable|string',
            'signataire'         => 'required|string|max:200',
            'fonction_signataire'=> 'required|string|max:200',
            'cachet'             => 'nullable|image|max:2048',
            'signature_fichier'  => 'nullable|image|max:2048',
            'signature_base64'   => 'nullable|string',
            'est_publiee'        => 'boolean',
            'est_telechargeable' => 'boolean',
        ]);

        // Sceau
        $cachetPath = $lettre->cachet_path;
        if ($request->hasFile('cachet')) {
            if ($lettre->cachet_path) Storage::disk('public')->delete($lettre->cachet_path);
            $cachetPath = $request->file('cachet')->store('lettres/cachets', 'public');
        }

        // Signature électronique
        $signaturePath = $lettre->signature_path;
        if ($request->filled('signature_base64')) {
            if ($lettre->signature_path) Storage::disk('public')->delete($lettre->signature_path);
            $b64 = preg_replace('/^data:image\/\w+;base64,/', '', $request->signature_base64);
            $decoded = base64_decode($b64);
            $filename = 'lettres/signatures/' . uniqid() . '.png';
            Storage::disk('public')->put($filename, $decoded);
            $signaturePath = $filename;
        } elseif ($request->hasFile('signature_fichier')) {
            if ($lettre->signature_path) Storage::disk('public')->delete($lettre->signature_path);
            $signaturePath = $request->file('signature_fichier')->store('lettres/signatures', 'public');
        }

        $ampliations = [];
        if (!empty($data['ampliations'])) {
            $ampliations = array_filter(array_map('trim', explode("\n", $data['ampliations'])));
        }

        $lettre->update([
            'numero'             => $data['numero'],
            'date_lettre'        => $data['date_lettre'],
            'destinataire'       => $data['destinataire'],
            'objet'              => $data['objet'],
            'corps'              => $data['corps'],
            'ampliations'        => array_values($ampliations),
            'signataire'         => $data['signataire'],
            'fonction_signataire'=> $data['fonction_signataire'],
            'cachet_path'        => $cachetPath,
            'signature_path'     => $signaturePath,
            'est_publiee'        => $request->boolean('est_publiee'),
            'est_telechargeable' => $request->boolean('est_telechargeable', true),
        ]);

        return redirect()->route('administration.lettres.show', $lettre)
            ->with('success', 'Lettre mise à jour.');
    }

    public function destroy(Lettre $lettre)
    {
        $lettre->delete();
        return redirect()->route('administration.lettres.index')
            ->with('success', 'Lettre supprimée.');
    }

    public function togglePublier(Lettre $lettre)
    {
        $lettre->update(['est_publiee' => !$lettre->est_publiee]);
        $msg = $lettre->est_publiee ? 'Lettre publiée.' : 'Lettre masquée.';
        return back()->with('success', $msg);
    }

    public function telechargerPdf(Lettre $lettre)
    {
        $pdf  = Pdf::loadView('administration.lettres.pdf', compact('lettre'))
            ->setPaper('A4', 'portrait');
        $nom  = 'Lettre-' . $this->nomFichier($lettre->numero) . '.pdf';
        return $pdf->download($nom);
    }

    public function voirPdf(Lettre $lettre)
    {
        $pdf  = Pdf::loadView('administration.lettres.pdf', compact('lettre'))
            ->setPaper('A4', 'portrait');
        $nom  = 'Lettre-' . $this->nomFichier($lettre->numero) . '.pdf';
        return $pdf->stream($nom);
    }

    public function telechargerPublic(Lettre $lettre)
    {
        abort_unless($lettre->est_publiee && $lettre->est_telechargeable, 403);
        $pdf  = Pdf::loadView('administration.lettres.pdf', compact('lettre'))
            ->setPaper('A4', 'portrait');
        $nom  = 'SYNEM-Lettre-' . $this->nomFichier($lettre->numero) . '.pdf';
        return $pdf->download($nom);
    }

    // Assistance IA
    public function assistanceIa(Request $request)
    {
        $request->validate(['prompt' => 'required|string|max:3000']);

        $apiKey = config('services.groq.key');
        if (!$apiKey) {
            return response()->json([
                'error' => 'Assistant IA non configuré. Ajoutez GROQ_API_KEY dans le fichier .env.',
            ], 503);
        }

        $systemPrompt = "Tu es un expert en rédaction administrative et syndicale. Tu aides à rédiger des lettres officielles pour le SYNEM (Syndicat National des Enseignants du Mali). Tes réponses doivent être en français, avec un ton formel, professionnel et syndical. Fournis uniquement le texte amélioré ou proposé, sans explications supplémentaires.";

        try {
            $response = Http::withToken($apiKey)
                ->acceptJson()
                ->connectTimeout(10)
                ->timeout(60)
                ->post(config('services.groq.url'), [
                    'model' => config('services.groq.model'),
                    'temperature' => 0.4,
                    'max_completion_tokens' => 1200,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $request->prompt],
                    ],
                ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'error' => 'Le service IA est temporairement inaccessible. Réessayez dans quelques instants.',
            ], 503);
        }

        if ($response->failed()) {
            $message = match ($response->status()) {
                401, 403 => 'La clé API Groq est invalide ou non autorisée.',
                429 => 'Le quota gratuit de l\'assistant IA est momentanément atteint. Réessayez plus tard.',
                default => 'Erreur lors de la communication avec l\'assistant IA.',
            };

            return response()->json(['error' => $message], $response->status() >= 500 ? 503 : $response->status());
        }

        $text = trim((string) $response->json('choices.0.message.content', ''));
        if ($text === '') {
            return response()->json(['error' => 'L\'assistant IA n\'a retourné aucun texte.'], 502);
        }

        return response()->json(['result' => $text]);
    }

    private function genererNumero(): string
    {
        $annee    = date('Y');
        $derniere = Lettre::withTrashed()->whereYear('created_at', $annee)->count() + 1;
        return sprintf('%s-%03d/BEN-SYNEM', $annee, $derniere);
    }

    private function nomFichier(string $numero): string
    {
        return preg_replace('/[\/\\\\\s]+/', '-', $numero);
    }
}
