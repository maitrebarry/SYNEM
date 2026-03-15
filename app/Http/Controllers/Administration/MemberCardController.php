<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\MemberCardCampaign;
use App\Models\MemberCardPhotoSubmission;
use App\Models\Militant;
use App\Support\MemberCardTemplates;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MemberCardController extends Controller
{
    public function index(Request $request)
    {
        $templates = MemberCardTemplates::all();
        $selectedTemplate = $request->get('template', 'horizon');
        $resolvedTemplate = $this->resolveCardOptions($request);

        $activeCampaign = MemberCardCampaign::query()
            ->withCount([
                'submissions',
                'submissions as pending_submissions_count' => fn ($query) => $query->where('status', 'pending'),
                'submissions as approved_submissions_count' => fn ($query) => $query->where('status', 'approved'),
                'submissions as revision_submissions_count' => fn ($query) => $query->where('status', 'revision_requested'),
            ])
            ->active()
            ->latest('sent_at')
            ->first();

        $submissions = MemberCardPhotoSubmission::query()
            ->with(['militant', 'campaign', 'reviewer'])
            ->when($request->filled('submission_status') && $request->submission_status !== 'all', function ($query) use ($request) {
                $query->where('status', $request->submission_status);
            })
            ->latest('submitted_at')
            ->paginate(12)
            ->withQueryString();

        $approvedMilitants = Militant::query()
            ->where('status', 'approved')
            ->count();

        $eligibleCards = $this->eligibleCards($request->input('militant_ids'));
        $previewCards = $this->buildCards($eligibleCards->take(8), $resolvedTemplate);

        $stats = [
            'approved_militants' => $approvedMilitants,
            'received_submissions' => MemberCardPhotoSubmission::count(),
            'approved_cards' => MemberCardPhotoSubmission::where('status', 'approved')->count(),
            'pending_cards' => MemberCardPhotoSubmission::where('status', 'pending')->count(),
        ];

        return view('administration.member-cards.index', compact(
            'templates',
            'resolvedTemplate',
            'selectedTemplate',
            'activeCampaign',
            'submissions',
            'previewCards',
            'eligibleCards',
            'stats'
        ));
    }

    public function storeCampaign(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:150',
            'message' => 'required|string|max:2000',
        ]);

        MemberCardCampaign::query()
            ->active()
            ->update([
                'status' => 'closed',
                'closed_at' => now(),
            ]);

        MemberCardCampaign::create([
            'title' => $request->title,
            'message' => $request->message,
            'status' => 'active',
            'sent_by' => Auth::id(),
            'sent_at' => now(),
        ]);

        return redirect()
            ->route('administration.pages.cartes-membres.index')
            ->with('success', 'La demande collective de photo a été envoyée.');
    }

    public function closeCampaign(MemberCardCampaign $campaign)
    {
        $campaign->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return redirect()
            ->route('administration.pages.cartes-membres.index')
            ->with('success', 'La campagne photo a été clôturée.');
    }

    public function updateMilitantIdentity(Request $request, Militant $militant)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'tel' => 'required|string|max:50',
            'n_cartes_syndicale' => 'required|string|max:50',
            'division' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'coordinations' => 'nullable|string|max:255',
        ]);

        $militant->update($request->only([
            'nom',
            'prenom',
            'tel',
            'n_cartes_syndicale',
            'division',
            'region',
            'coordinations',
        ]) + [
            'name' => trim($request->prenom . ' ' . $request->nom),
        ]);

        return redirect()
            ->route('administration.pages.cartes-membres.index', ['submission_status' => request('submission_status', 'all')])
            ->with('success', 'Les informations carte du militant ont été mises à jour.');
    }

    public function reviewSubmission(Request $request, MemberCardPhotoSubmission $submission)
    {
        $request->validate([
            'status' => ['required', Rule::in(['approved', 'revision_requested'])],
            'admin_comment' => 'nullable|string|max:1000',
            'redirect_submission_status' => ['nullable', Rule::in(['all', 'pending', 'approved', 'revision_requested'])],
        ]);

        $submission->update([
            'status' => $request->status,
            'admin_comment' => $request->admin_comment,
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
        ]);

        $redirectStatus = $request->input('redirect_submission_status', 'all');

        return redirect()
            ->route('administration.pages.cartes-membres.index', ['submission_status' => $redirectStatus])
            ->with('success', 'Le statut de la photo a été mis à jour.');
    }

    public function storeSignature(Request $request)
    {
        $request->validate([
            'signature_data' => 'nullable|string',
            'signature_file' => 'nullable|file|mimes:png,jpg,jpeg,webp|max:4096',
            'signature_text' => 'nullable|string|max:120',
        ]);

        if (!$request->hasFile('signature_file') && !$request->filled('signature_data') && !$request->filled('signature_text')) {
            return redirect()
                ->route('administration.pages.cartes-membres.index')
                ->withErrors(['signature' => 'Dessinez la signature, choisissez un fichier image ou saisissez un texte de signature avant de valider.']);
        }

        $this->deleteStoredSignature(session('member_card_signature_path'));
        session()->forget('member_card_signature_text');

        if ($request->hasFile('signature_file')) {
            $extension = $request->file('signature_file')->getClientOriginalExtension() ?: 'png';
            $path = 'member-cards/signatures/signature_' . now()->format('Ymd_His') . '_' . Str::lower(Str::random(8)) . '.' . Str::lower($extension);
            Storage::disk('public')->putFileAs('member-cards/signatures', $request->file('signature_file'), basename($path));
            session(['member_card_signature_path' => $path]);
        } else {
            if ($request->filled('signature_data')) {
                $signatureData = (string) $request->input('signature_data');

                abort_unless(str_starts_with($signatureData, 'data:image/png;base64,'), 422, 'Signature invalide.');

                $binary = base64_decode(substr($signatureData, strlen('data:image/png;base64,')), true);

                abort_if($binary === false, 422, 'Impossible de lire la signature.');

                $path = 'member-cards/signatures/signature_' . now()->format('Ymd_His') . '_' . Str::lower(Str::random(8)) . '.png';
                Storage::disk('public')->put($path, $binary);
                session(['member_card_signature_path' => $path]);
            }

            if ($request->filled('signature_text')) {
                session(['member_card_signature_text' => trim((string) $request->input('signature_text'))]);
            }
        }

        return redirect()
            ->route('administration.pages.cartes-membres.index')
            ->with('success', 'La signature electronique a ete enregistree.');
    }

    public function clearSignature()
    {
        $this->deleteStoredSignature(session('member_card_signature_path'));
        session()->forget('member_card_signature_path');
        session()->forget('member_card_signature_text');

        return redirect()
            ->route('administration.pages.cartes-membres.index')
            ->with('success', 'La signature enregistree a ete supprimee.');
    }

    public function destroySubmission(MemberCardPhotoSubmission $submission)
    {
        if ($submission->photo_path && Storage::disk('public')->exists($submission->photo_path)) {
            Storage::disk('public')->delete($submission->photo_path);
        }

        $submission->delete();

        return redirect()
            ->back()
            ->with('success', 'La carte et la photo associee ont ete supprimees.');
    }

    public function exportPdf(Request $request): Response
    {
        $template = $this->resolveCardOptions($request);

        $cards = $this->buildCards($this->eligibleCards($request->input('militant_ids')), $template);

        abort_if($cards->isEmpty(), 422, 'Aucune carte disponible pour export.');

        $pdf = Pdf::loadView('administration.member-cards.pdf', [
            'cards' => $cards,
            'template' => $template,
        ])->setPaper('a4', 'portrait');

        $filename = 'cartes-membres-synem-' . now()->format('Ymd-His') . '.pdf';

        if ($request->boolean('inline')) {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }

    public function downloadSinglePdf(Request $request, Militant $militant): Response
    {
        $template = $this->resolveCardOptions($request);

        $cards = $this->buildCards($this->eligibleCards([$militant->id]), $template);

        abort_if($cards->isEmpty(), 404, 'Aucune carte validée pour ce militant.');

        $filename = 'carte-membre-' . ($militant->n_cartes_syndicale ?: $militant->id) . '.pdf';
        $pdf = Pdf::loadView('administration.member-cards.pdf', [
            'cards' => $cards,
            'template' => $template,
        ])->setPaper('a4', 'portrait');

        if ($request->boolean('inline')) {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }

    public function downloadSingleImage(Request $request, Militant $militant): Response
    {
        $template = $this->resolveCardOptions($request);
        $cards = $this->buildCards($this->eligibleCards([$militant->id]), $template);

        abort_if($cards->isEmpty(), 404, 'Aucune carte validée pour ce militant.');

        $svg = view('administration.member-cards.svg', [
            'card' => $cards->first(),
            'template' => $template,
        ])->render();

        $filename = 'carte-membre-' . ($militant->n_cartes_syndicale ?: $militant->id) . '.svg';

        if ($request->boolean('inline')) {
            return response($svg, 200, ['Content-Type' => 'image/svg+xml; charset=UTF-8']);
        }

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function eligibleCards(array|string|null $militantIds = null): Collection
    {
        $ids = collect(is_array($militantIds) ? $militantIds : [$militantIds])
            ->filter()
            ->map(fn ($value) => (int) $value)
            ->unique()
            ->values();

        $submissions = MemberCardPhotoSubmission::query()
            ->with('militant')
            ->where('status', 'approved')
            ->whereHas('militant', fn ($query) => $query->where('status', 'approved'))
            ->when($ids->isNotEmpty(), fn ($query) => $query->whereIn('militant_id', $ids))
            ->orderByDesc('submitted_at')
            ->get()
            ->unique('militant_id')
            ->values();

        return $submissions;
    }

    private function buildCards(Collection $submissions, array $template): Collection
    {
        $logo = $this->resolveLogoDataUri($template);
        $signature = $this->resolveSignatureDataUri($template);
        $signatureText = $template['signature_text'];

        return $submissions->map(function (MemberCardPhotoSubmission $submission) use ($template, $logo, $signature, $signatureText) {
            $militant = $submission->militant;
            $cardNumber = $militant->n_cartes_syndicale ?: sprintf('SYNEM-%05d', $militant->id);
            $qrPayload = $this->buildOfflineQrPayload($militant, $cardNumber, $template);

            return [
                'militant' => $militant,
                'submission' => $submission,
                'full_name' => $militant->full_name ?: $militant->name,
                'nom' => $militant->nom,
                'prenom' => $militant->prenom,
                'card_number' => $cardNumber,
                'division' => $militant->division_label,
                'region' => $militant->region_label,
                'coordination' => $militant->coordinations ?: $militant->region_label,
                'phone' => $militant->tel,
                'status_label' => 'Militant approuvé',
                'price_label' => $template['price_label'],
                'secretary_general_title' => $template['secretary_general_title'],
                'secretary_general_name' => $template['secretary_general_name'],
                'year_label' => $template['year_label'],
                'header_motto' => $template['header_motto'],
                'identifier' => 'ID-' . $cardNumber,
                'photo' => $this->storageFileToDataUri($submission->photo_path),
                'logo' => $logo,
                'signature_image' => $signature,
                'signature_text' => $signatureText,
                'show_logo' => $template['show_logo'],
                'show_qr' => $template['show_qr'],
                'show_border' => $template['show_border'],
                'show_flag_band' => $template['show_flag_band'],
                'show_secretary_block' => $template['show_secretary_block'],
                'text_color' => $template['text_color'],
                'header_text_color' => $template['header_text_color'],
                'qr_payload' => $qrPayload,
                'qr_code' => $template['show_qr'] ? $this->generateQrCodeDataUri($qrPayload) : null,
                'verification_url' => null,
                'template' => $template,
            ];
        })->filter(fn ($card) => !empty($card['photo']))->values();
    }

    private function resolveCardOptions(Request $request): array
    {
        $template = MemberCardTemplates::resolve(
            $request->get('template', 'horizon'),
            $request->get('primary_color'),
            $request->get('secondary_color'),
            $request->get('accent_color')
        );

        $template['header_motto'] = trim((string) $request->get('header_motto', 'Unite - Action - Justice - ' . now()->format('Y')));
        $template['price_label'] = trim((string) $request->get('price_label', '2000 F CFA'));
        $template['secretary_general_title'] = trim((string) $request->get('secretary_general_title', 'Secretaire General'));
        $template['secretary_general_name'] = trim((string) $request->get('secretary_general_name', 'Bureau National du SYNEM'));
        $template['year_label'] = trim((string) $request->get('year_label', now()->format('Y')));
        $template['logo_path'] = trim((string) $request->get('logo_path', 'template-admin/assets/images/syneklogo.jpeg'));
        $template['signature_path'] = trim((string) $request->get('signature_path', session('member_card_signature_path', '')));
        $template['signature_text'] = trim((string) $request->get('signature_text', session('member_card_signature_text', $request->get('secretary_general_name', ''))));
        $template['text_color'] = $this->normalizeColor((string) $request->get('text_color', $this->contrastColor($template['accent'])));
        $template['header_text_color'] = $this->normalizeColor((string) $request->get('header_text_color', $this->contrastColor($template['primary'])));
        $template['show_logo'] = $request->boolean('show_logo', true);
        $template['show_qr'] = $request->boolean('show_qr', true);
        $template['show_border'] = $request->boolean('show_border', true);
        $template['show_flag_band'] = $request->boolean('show_flag_band', true);
        $template['show_secretary_block'] = $request->boolean('show_secretary_block', true);

        return $template;
    }

    private function resolveLogoDataUri(array $template): ?string
    {
        if (!$template['show_logo']) {
            return null;
        }

        $logoPath = public_path(ltrim($template['logo_path'], '/'));

        return $this->fileToDataUri($logoPath);
    }

    private function resolveSignatureDataUri(array $template): ?string
    {
        if (empty($template['signature_path'])) {
            return null;
        }

        $signaturePath = $template['signature_path'];

        if (Storage::disk('public')->exists($signaturePath)) {
            return $this->fileToDataUri(Storage::disk('public')->path($signaturePath));
        }

        $publicPath = public_path(ltrim($signaturePath, '/'));

        return $this->fileToDataUri($publicPath);
    }

    private function generateQrCodeDataUri(string $payload): string
    {
        $result = (new Builder(
            writer: new PngWriter(),
            data: $payload,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: 220,
            margin: 6,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
        ))->build();

        return $result->getDataUri();
    }

    private function buildOfflineQrPayload(Militant $militant, string $cardNumber, array $template): string
    {
        return implode("\n", [
            'Organisation : SYNEM',
            'Nom : ' . $militant->nom,
            'Prenom : ' . $militant->prenom,
            'Numero de la carte : ' . $cardNumber,
            'Division : ' . $militant->division_label,
            'Coordination / Region : ' . $militant->region_label,
            'Telephone : ' . $militant->tel,
            'Statut : Membre actif',
            'Annee : ' . $template['year_label'],
        ]);
    }

    private function storageFileToDataUri(?string $path): ?string
    {
        if (!$path || !Storage::disk('public')->exists($path)) {
            return null;
        }

        $absolutePath = Storage::disk('public')->path($path);

        return $this->fileToDataUri($absolutePath);
    }

    private function fileToDataUri(?string $path): ?string
    {
        if (!$path || !is_file($path)) {
            return null;
        }

        $mime = mime_content_type($path) ?: 'image/jpeg';
        $content = file_get_contents($path);

        return 'data:' . $mime . ';base64,' . base64_encode($content);
    }

    private function normalizeColor(string $color): string
    {
        $color = trim($color);

        if (preg_match('/^#([A-Fa-f0-9]{6})$/', $color)) {
            return strtoupper($color);
        }

        return '#111827';
    }

    private function contrastColor(string $backgroundColor): string
    {
        $color = ltrim($this->normalizeColor($backgroundColor), '#');
        $red = hexdec(substr($color, 0, 2));
        $green = hexdec(substr($color, 2, 2));
        $blue = hexdec(substr($color, 4, 2));
        $luminance = (($red * 299) + ($green * 587) + ($blue * 114)) / 1000;

        return $luminance > 160 ? '#111827' : '#FFFFFF';
    }

    private function deleteStoredSignature(?string $path): void
    {
        if (!$path || !str_starts_with($path, 'member-cards/signatures/')) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}