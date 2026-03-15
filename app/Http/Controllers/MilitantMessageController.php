<?php

namespace App\Http\Controllers;

use App\Models\MemberCardCampaign;
use App\Models\MemberCardPhotoSubmission;
use App\Models\Militant;
use App\Models\MilitantMessage;
use Illuminate\Http\Request;

class MilitantMessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:2000',
        ]);

        $militantId = session('verified_militant');
        if (!$militantId) {
            return response()->json([
                'success' => false,
                'message' => 'Session expirée. Veuillez vous reconnecter.',
            ], 403);
        }

        $militant = Militant::find($militantId);
        if (!$militant || $militant->status !== 'approved') {
            session()->forget('verified_militant');
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.',
            ], 403);
        }

        $message = MilitantMessage::create([
            'militant_id' => $militant->id,
            'question' => $request->question,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Votre question a bien été envoyée.',
            'chat' => [
                'id' => $message->id,
                'question' => $message->question,
                'status' => $message->status,
                'created_at' => $message->created_at->format('d/m/Y H:i'),
            ],
        ], 201);
    }

    public function adminIndex()
    {
        $messages = MilitantMessage::with('militant')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $activeMemberCardCampaign = MemberCardCampaign::query()
            ->withCount([
                'submissions',
                'submissions as pending_submissions_count' => fn ($query) => $query->where('status', 'pending'),
                'submissions as approved_submissions_count' => fn ($query) => $query->where('status', 'approved'),
                'submissions as revision_submissions_count' => fn ($query) => $query->where('status', 'revision_requested'),
            ])
            ->active()
            ->latest('sent_at')
            ->first();

        $latestMemberCardSubmissions = MemberCardPhotoSubmission::with(['militant', 'campaign'])
            ->latest('submitted_at')
            ->take(6)
            ->get();

        return view('administration.militants.messages', compact(
            'messages',
            'activeMemberCardCampaign',
            'latestMemberCardSubmissions'
        ));
    }

    public function reply(Request $request, MilitantMessage $message)
    {
        $request->validate([
            'answer' => 'required|string|max:2500',
        ]);

        $message->update([
            'answer' => $request->answer,
            'status' => 'answered',
            'is_admin_read' => true,
        ]);

        return redirect()
            ->route('administration.pages.militant-messages.index')
            ->with('success', 'Réponse envoyée au militant.');
    }
}
