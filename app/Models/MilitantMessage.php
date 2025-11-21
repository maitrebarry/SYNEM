<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Militant;

class MilitantMessage extends Model
{
    use HasFactory;

    protected $table = 'militant_messages';

    protected $fillable = [
        'militant_id',
        'question',
        'answer',
        'status',
        'is_admin_read',
    ];

    protected $casts = [
        'is_admin_read' => 'boolean',
    ];

    public function militant()
    {
        return $this->belongsTo(Militant::class);
    }
}
