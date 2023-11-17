<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NativeLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'residence'
    ];

    public function subtribes()
    {
        return $this->hasMany(Subtribe::class)->withTimestamps();
    }

    public function proverbs()
    {
        return $this->hasMany(Proverb::class)->withTimestamps();
    }
}
