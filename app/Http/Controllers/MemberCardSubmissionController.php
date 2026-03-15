<?php

namespace App\Http\Controllers;

use App\Models\MemberCardCampaign;
use App\Models\MemberCardPhotoSubmission;
use App\Models\Militant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class MemberCardSubmissionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $militantId = session('verified_militant');

        if (!$militantId) {
            return redirect()
                ->route('militant.documents.access')
                ->withErrors(['access' => 'Session expirée. Veuillez vous reconnecter.']);
        }

        $militant = Militant::find($militantId);
        if (!$militant || $militant->status !== 'approved') {
            session()->forget('verified_militant');

            return redirect()
                ->route('militant.documents.access')
                ->withErrors(['access' => 'Accès refusé.']);
        }

        $request->validate([
            'campaign_id' => 'required|integer|exists:member_card_campaigns,id',
            'captured_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'uploaded_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'webcam_photo' => 'nullable|string',
        ]);

        $campaign = MemberCardCampaign::query()
            ->active()
            ->findOrFail($request->integer('campaign_id'));

        $photo = $request->file('captured_photo') ?: $request->file('uploaded_photo');
        $path = null;

        if ($photo instanceof UploadedFile) {
            $path = $photo->store('member-cards/photos', 'public');
        } elseif ($request->filled('webcam_photo')) {
            $path = $this->storeWebcamPhoto($request->string('webcam_photo')->toString());
        }

        if (!$path) {
            throw ValidationException::withMessages([
                'uploaded_photo' => 'Veuillez prendre une photo avec la caméra ou téléverser un fichier image.',
            ]);
        }

        $existingSubmission = MemberCardPhotoSubmission::query()
            ->where('militant_id', $militant->id)
            ->where('member_card_campaign_id', $campaign->id)
            ->first();

        if ($existingSubmission && $existingSubmission->photo_path) {
            Storage::disk('public')->delete($existingSubmission->photo_path);
        }

        MemberCardPhotoSubmission::updateOrCreate(
            [
                'militant_id' => $militant->id,
                'member_card_campaign_id' => $campaign->id,
            ],
            [
                'photo_path' => $path,
                'status' => 'pending',
                'admin_comment' => null,
                'submitted_at' => now(),
                'reviewed_at' => null,
                'reviewed_by' => null,
            ]
        );

        return redirect()
            ->route('militant.documents.index')
            ->with('success', 'Votre photo a été envoyée pour validation.');
    }

    private function storeWebcamPhoto(string $dataUri): ?string
    {
        if (!preg_match('/^data:image\/(png|jpe?g|webp);base64,/', $dataUri, $matches)) {
            throw ValidationException::withMessages([
                'webcam_photo' => 'Le format de la photo prise par caméra est invalide.',
            ]);
        }

        $binary = base64_decode(substr($dataUri, strpos($dataUri, ',') + 1), true);
        if ($binary === false) {
            throw ValidationException::withMessages([
                'webcam_photo' => 'La photo prise par caméra est corrompue.',
            ]);
        }

        if (strlen($binary) > 5 * 1024 * 1024) {
            throw ValidationException::withMessages([
                'webcam_photo' => 'La photo prise par caméra dépasse 5 Mo.',
            ]);
        }

        $extension = match (strtolower($matches[1])) {
            'jpeg', 'jpg' => 'jpg',
            default => strtolower($matches[1]),
        };

        $path = 'member-cards/photos/webcam_' . now()->format('YmdHis') . '_' . uniqid() . '.' . $extension;
        Storage::disk('public')->put($path, $binary);

        return $path;
    }
}