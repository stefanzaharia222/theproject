<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class TicketsUsers extends Model
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $table = 'tickets_users';

    protected $fillable = [
        'ticket_id',
        'user_id'
    ];
}
