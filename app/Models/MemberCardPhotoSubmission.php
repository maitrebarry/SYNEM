<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MemberCardPhotoSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'militant_id',
        'member_card_campaign_id',
        'photo_path',
        'status',
        'admin_comment',
        'submitted_at',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function militant()
    {
        return $this->belongsTo(Militant::class);
    }

    public function campaign()
    {
        return $this->belongsTo(MemberCardCampaign::class, 'member_card_campaign_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function getPhotoUrlAttribute()
    {
        return Storage::url($this->photo_path);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'approved' => 'Validée',
            'revision_requested' => 'Nouvelle photo demandée',
            default => 'En attente',
        };
    }
}