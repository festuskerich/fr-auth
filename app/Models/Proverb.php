<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proverb extends Model
{
    use HasFactory;
    public $fillable = [
        'local_proverb',
        'language_id'
    ];
    public function nativeLanguge()
    {
        return $this->belongsToMany(NativeLanguage::class)->withTimestamps();
    }
}
