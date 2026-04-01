<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest query()
 * @property int $id
 * @property string $lang_locale
 * @property string $name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $field
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest whereLangLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest whereUpdatedAt($value)
 * @property string $surname
 * @property string|null $subject
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactFormRequest whereSurname($value)
 * @mixin \Eloquent
 */
class ContactFormRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'content',
        'lang_locale',
        'page_url',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    protected $table = 'contact_request';

    /**
     * Scope pro nepřečtené zprávy
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Označí zprávu jako přečtenou
     */
    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }
}
