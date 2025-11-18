<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPageContent extends Model
{
    protected $table = 'about_page_contents';
    protected $guarded = [];
    public $timestamps = true;

    protected $casts = [
        'timeline' => 'array',
        'team' => 'array',
    ];
}
