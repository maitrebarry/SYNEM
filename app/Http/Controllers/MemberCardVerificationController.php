<?php

namespace App\Http\Controllers;

use App\Models\Militant;

class MemberCardVerificationController extends Controller
{
    public function show(Militant $militant)
    {
        abort_unless($militant->status === 'approved', 404);

        $submission = $militant->latestCardPhotoSubmission;
        abort_unless($submission && $submission->status === 'approved', 404);

        return view('site-web.militant-documents.card-verification', [
            'militant' => $militant,
            'submission' => $submission,
        ]);
    }
}