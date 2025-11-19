<?php

namespace App\Http\Controllers\SiteWeb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactSubmission;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Mail\NewContactSubmission;

class ContactSubmissionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'organisation' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:2000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            // store on private disk root (storage/app/private/contact_submissions)
            Storage::disk('local')->putFileAs('contact_submissions', $file, $name);
            // Save only filename
            $data['attachment'] = $name;
        }

        $submission = ContactSubmission::create($data);

        // Send notification to admin
        Mail::to(config('mail.from.address', 'admin@synem.com'))->send(new NewContactSubmission($submission));

        return response()->json(['success' => true, 'message' => 'Votre demande a été soumise. Nous reviendrons vers vous.', 'id' => $submission->id]);
    }
}
