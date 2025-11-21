<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\MilitantMessage;

class Militant extends Model
{
    use HasFactory;

    protected $table = 'militants';

    protected $fillable = [
        'nom', 'prenom', 'name', 'email', 'tel', 'n_cartes_syndicale', 'coordinations', 'message', 'member_card_photo', 'status', 'approved_by', 'admin_comment', 'approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    // Accessor pour obtenir le nom complet
    public function getFullNameAttribute()
    {
        if ($this->nom && $this->prenom) {
            return $this->prenom . ' ' . $this->nom;
        }
        return $this->name ?? '';
    }

    // Mutator pour définir nom et prénom depuis name
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;

        // Si on définit name, essayer de séparer en nom et prénom
        $parts = explode(' ', $value, 2);
        if (count($parts) === 2) {
            $this->attributes['prenom'] = $parts[0];
            $this->attributes['nom'] = $parts[1];
        } else {
            $this->attributes['prenom'] = $value;
            $this->attributes['nom'] = '';
        }
    }

    public function getMemberCardPhotoUrlAttribute()
    {
        if (!$this->member_card_photo) {
            return null;
        }

        // Files are stored on the public disk, so we can use Storage::url()
        return Storage::url($this->member_card_photo);
    }

    public function messages()
    {
        return $this->hasMany(MilitantMessage::class)->orderBy('created_at', 'asc');
    }
}
