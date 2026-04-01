<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $fillable = [
        'source_path',
        'target_path',
        'status',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'status' => 'integer',
    ];
}