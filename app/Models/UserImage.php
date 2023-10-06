<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserImage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'path',
        'user_id'
    ];

    /**
     * @return BelongsTo
     * @description Get the post that owns the details
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
