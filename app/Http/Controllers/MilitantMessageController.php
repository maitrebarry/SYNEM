<?php

namespace App\Http\Controllers;

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

        return view('administration.militants.messages', compact('messages'));
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
