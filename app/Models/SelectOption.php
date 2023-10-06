<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectOption extends Model
{
    use HasFactory;

    protected $table = 'select_options';

    protected $fillable = [
        'option_name',
        'option_kind',
        'tooltip',
        'placeholder',
        'description',
    ];
}