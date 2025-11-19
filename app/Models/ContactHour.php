<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactHour extends Model
{
    use HasFactory;

    protected $table = 'contact_hours';
    protected $fillable = ['day','open','close','closed','ordering'];
}
