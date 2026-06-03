<?php

namespace App\Models\AuthorizedAccess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthorizedAccessDownload extends Model
{
    use HasFactory;

    protected $fillable = [
        'folder_id',
        'code',
        'title',
        'description',
        'file',
        'sort',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(AuthorizedAccessFolder::class, 'folder_id');
    }
}