<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $table = 'contact_submissions';

    protected $fillable = [
        'name', 'email', 'phone', 'organisation', 'message', 'attachment', 'status', 'approved_by', 'admin_comment', 'approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function getAttachmentUrlAttribute()
    {
        if (!$this->attachment) {
            return null;
        }

        // Files are stored on the private disk; provide a route to stream them via controller.
        return route('administration.contact.submission.attachment', ['id' => $this->id]);
    }
}
