<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberCardCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'status',
        'sent_by',
        'sent_at',
        'closed_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function submissions()
    {
        return $this->hasMany(MemberCardPhotoSubmission::class, 'member_card_campaign_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}