<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $locale
 * @property int $active
 * @property string $icon
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Language newModelQuery()
 * @method static Builder|Language newQuery()
 * @method static Builder|Language query()
 * @method static Builder|Language whereActive($value)
 * @method static Builder|Language whereCreatedAt($value)
 * @method static Builder|Language whereIcon($value)
 * @method static Builder|Language whereId($value)
 * @method static Builder|Language whereLocale($value)
 * @method static Builder|Language whereName($value)
 * @method static Builder|Language whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    use HasFactory;

    public static function boot(): void
    {
        parent::boot();
        Model::unguard();
    }

    public static function getAllowedLanguageLocale(): array
    {
        return ['cs','en','pl','sk','de','fr','ru','it','es'];
    }
}
