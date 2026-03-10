<?php

namespace App\Http\Controllers;

use App\Mail\MilitantApprovedNotification;
use App\Models\Militant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MilitantController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:militants,email',
            'tel' => 'required|string|max:20|unique:militants,tel',
            'n_cartes_syndicale' => 'required|string|max:50|unique:militants,n_cartes_syndicale',
            'coordinations' => 'required|string|max:255',
            'message' => 'nullable|string',
            'member_card_photo' => 'required|string', // Base64 encoded image
        ]);

        // Decode the base64 image
        $imageData = $request->member_card_photo;
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
        $imageData = str_replace('data:image/jpg;base64,', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $imageData = base64_decode($imageData);

        // Generate unique filename
        $filename = 'militant_' . time() . '_' . uniqid() . '.png';
        $path = 'militants/' . $filename;

        // Store the image
        Storage::disk('public')->put($path, $imageData);

        // Create militant record
        Militant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'name' => $request->prenom . ' ' . $request->nom, // Pour compatibilité
            'email' => $request->email,
            'tel' => $request->tel,
            'n_cartes_syndicale' => $request->n_cartes_syndicale,
            'coordinations' => $request->coordinations,
            'message' => $request->message,
            'member_card_photo' => $path,
            'status' => 'pending',
        ]);

        return response()->json(['success' => true, 'message' => 'Votre demande de militant a été soumise avec succès. Elle sera examinée par notre équipe.']);
    }

   public function index(Request $request)
{
    // Si c'est une requête AJAX pour le filtrage, retourner toutes les données filtrées
    if ($request->ajax()) {
        $militants = $this->filteredMilitantQuery($request)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'data' => $militants->map(function($militant, $index) {
                return [
                    'id' => $militant->id,
                    'numero' => $index + 1,
                    'nom' => $militant->nom,
                    'prenom' => $militant->prenom,
                    'email' => $militant->email,
                    'tel' => $militant->tel ?: '-',
                    'n_cartes_syndicale' => $militant->n_cartes_syndicale ?: '-',
                    'coordinations' => $militant->coordinations ?: '-',
                    'status' => $militant->status,
                    'created_at' => $militant->created_at->format('d/m/Y H:i'),
                    'actions' => view('administration.militants.partials.actions', compact('militant'))->render()
                ];
            }),
            'total' => $militants->count()
        ]);
    }

    $militants = $this->filteredMilitantQuery($request)
        ->orderBy('created_at', 'desc')
        ->paginate(50);

    $coordinations = Militant::distinct()->pluck('coordinations')->filter()->sort()->values();

    $stats = [
        'total' => Militant::count(),
        'pending' => Militant::where('status', 'pending')->count(),
        'approved' => Militant::where('status', 'approved')->count(),
        'rejected' => Militant::where('status', 'rejected')->count(),
    ];

    return view('administration.militants.index', compact('militants', 'coordinations', 'stats'));
}

    public function exportExcel(Request $request)
    {
        return $this->exportMilitants($request, 'xls', 'application/vnd.ms-excel');
    }

    public function exportWord(Request $request)
    {
        return $this->exportMilitants($request, 'doc', 'application/msword');
    }


    public function show(Militant $militant)
    {
        return view('administration.militants.show', compact('militant'));
    }

    public function updateStatus(Request $request, Militant $militant)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($request->status === 'rejected') {
            $militant->delete();
        } else {
            $militant->update(['status' => $request->status]);
            if ($request->status === 'approved') {
                $this->sendApprovalEmail($militant);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Statut du militant mis à jour avec succès.',
                'status' => $request->status
            ]);
        }

        return redirect()
            ->route('administration.pages.militants.index')
            ->with('success', 'Statut du militant mis à jour avec succès.');
    }

    public function updateStatusAjax(Request $request, Militant $militant)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($request->status === 'rejected') {
            $militant->delete();
        } else {
            $militant->update(['status' => $request->status]);
            if ($request->status === 'approved') {
                $this->sendApprovalEmail($militant);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Statut du militant mis à jour avec succès.',
            'status' => $request->status
        ]);
    }

    protected function sendApprovalEmail(Militant $militant): void
    {
        try {
            Mail::to($militant->email)->send(new MilitantApprovedNotification($militant));
        } catch (\Throwable $e) {
            logger()->error('Échec envoi email approbation militant', [
                'militant_id' => $militant->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    protected function exportMilitants(Request $request, string $extension, string $contentType)
    {
        $militants = $this->filteredMilitantQuery($request)
            ->orderBy('created_at', 'desc')
            ->get();

        $content = view('administration.militants.exports.table', [
            'militants' => $militants,
            'generatedAt' => now(),
        ])->render();

        $filename = 'militants-' . now()->format('Ymd-His') . '.' . $extension;

        return response($content, 200, [
            'Content-Type' => $contentType . '; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    protected function filteredMilitantQuery(Request $request): Builder
    {
        $query = Militant::query();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('coordination') && $request->coordination !== 'all') {
            $query->where('coordinations', $request->coordination);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function (Builder $q) use ($search) {
                $q->where('nom', 'like', "%$search%")
                    ->orWhere('prenom', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('n_cartes_syndicale', 'like', "%$search%")
                    ->orWhere('tel', 'like', "%$search%")
                    ->orWhere('coordinations', 'like', "%$search%");
            });
        }

        return $query;
    }
}
