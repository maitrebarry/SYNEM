<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionPage extends Model
{
    protected $table = 'mission_pages';
    protected $guarded = [];
    protected $casts = [
        'mission_cta' => 'array',
    ];

    public function headerImages()
    {
        return $this->hasMany(MissionHeaderImage::class);
    }

    public function documents()
    {
        return $this->hasMany(MissionDocument::class);
    }

    public function items()
    {
        return $this->hasMany(MissionItem::class)->orderBy('ordering')->orderBy('id');
    }

    public function values()
    {
        return $this->hasMany(MissionValue::class)->orderBy('ordering')->orderBy('id');
    }
}
