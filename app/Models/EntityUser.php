<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class EntityUser extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $table = 'entity_user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'entity_id'
    ];

    /**
     * Get model platform
     *
     * @return HasOne
     */
    public function entity(): HasOne
    {
        return $this->hasOne(Entity::class, 'id', 'entity_id');
    }

    /**
     * Get model platform
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


}
