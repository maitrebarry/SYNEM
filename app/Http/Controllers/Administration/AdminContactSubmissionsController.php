<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactSubmission;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\ContactSubmissionResponse;
use App\Models\User;
use Illuminate\Support\Str;

class AdminContactSubmissionsController extends Controller
{
    public function index()
    {
        $submissions = ContactSubmission::orderBy('created_at', 'desc')->get();
        return view('administration.contact.submissions', compact('submissions'));
    }

    public function show($id)
    {
        $submission = ContactSubmission::findOrFail($id);
        return response()->json($submission);
    }

    public function attachment($id)
    {
        $submission = ContactSubmission::findOrFail($id);
        if (!$submission->attachment) {
            abort(404);
        }

        $path = 'contact_submissions/' . $submission->attachment;
        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        $stream = Storage::disk('local')->get($path);
        $fullPath = Storage::disk('local')->path($path);
        $mime = mime_content_type($fullPath);

        return response($stream, 200)
            ->header('Content-Type', $mime);
    }

    public function approve(Request $request, $id)
    {
        $submission = ContactSubmission::findOrFail($id);
        $submission->status = 'approved';
        $submission->approved_by = Auth::id() ?? null;
        $submission->approved_at = now();
        $submission->admin_comment = $request->input('comment');
        $submission->save();

        // Create user account
        $tempPassword = Str::random(10);
        User::create([
            'name' => $submission->name,
            'email' => $submission->email,
            'password' => bcrypt($tempPassword),
            'role' => 'member',
            'status' => 'active',
        ]);

        // Send response email
        Mail::to($submission->email)->send(new ContactSubmissionResponse($submission, true));

        return response()->json(['success' => true]);
    }

    public function reject(Request $request, $id)
    {
        $submission = ContactSubmission::findOrFail($id);
        $submission->status = 'rejected';
        $submission->approved_by = Auth::id() ?? null;
        $submission->admin_comment = $request->input('comment');
        $submission->approved_at = now();
        $submission->save();

        // Send response email
        Mail::to($submission->email)->send(new ContactSubmissionResponse($submission, false));

        return response()->json(['success' => true]);
    }
}
