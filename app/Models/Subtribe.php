<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtribe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'residence'
    ];

    public function nativeLanguge()
    {
        return $this->belongsToMany(NativeLanguage::class)->withTimestamps();
    }
}
