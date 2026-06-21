<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lettre extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'numero', 'date_lettre', 'destinataire', 'objet', 'corps',
        'ampliations', 'signataire', 'fonction_signataire',
        'cachet_path', 'signature_path', 'pieces_jointes', 'est_publiee', 'est_telechargeable', 'created_by',
    ];

    protected $casts = [
        'date_lettre'    => 'date',
        'ampliations'    => 'array',
        'pieces_jointes' => 'array',
        'est_publiee'    => 'boolean',
        'est_telechargeable' => 'boolean',
    ];

    public function auteur()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePubliees($query)
    {
        return $query->where('est_publiee', true);
    }

    public function scopeTelechargeable($query)
    {
        return $query->where('est_telechargeable', true);
    }

    public function getDateFormateAttribute(): string
    {
        return $this->date_lettre ? $this->date_lettre->translatedFormat('d F Y') : '';
    }

    public function getAmplificationsListAttribute(): array
    {
        return $this->ampliations ?? [];
    }
}
