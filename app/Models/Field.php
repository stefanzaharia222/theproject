<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fields';

    protected $fillable = [
        'code',
        'class',
        'type',
        'name',
        'tag',
        'placeholder',
        'tooltip',
        'description',
        'language',
    ];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

//    protected static function booted()
//    {
//        static::creating(function ($model) {
//            $model->code = uniqid();
//        });
//    }
}
