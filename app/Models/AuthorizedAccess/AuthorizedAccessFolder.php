<?php

namespace App\Models\AuthorizedAccess;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuthorizedAccessFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'page_type',
        'sort',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function downloads(): HasMany
    {
        return $this->hasMany(AuthorizedAccessDownload::class, 'folder_id')->orderBy('sort')->orderBy('title');
    }
}