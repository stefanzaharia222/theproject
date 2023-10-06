<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tickets';

    protected $fillable = [
        'name',
        'tag',
        'class',
        'type',
        'name',
        'code',
        'description',
        'language',
        'tooltip',
        'placeholder',
        'fields',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
