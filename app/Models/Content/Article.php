<?php

namespace App\Models\Content;

use App\Helpers\LocalizedRouteHelper;
use App\Interfaces\System\SitemapItem;
use App\Models\System\PageRoute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 *
 *
 * @property int $id
 * @property string $slug
 * @property string $lang_locale
 * @property int|null $user_id
 * @property string|null $title
 * @property array|null $content
 * @property int $active
 * @property int|null $can_open_detail
 * @property string|null $publish_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Content\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCanOpenDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereLangLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article wherePublishTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTags($value)
 * @mixin \Eloquent
 */
class Article extends Model implements SitemapItem
{
    use HasFactory;

    private Collection|bool $tagsCache = false;

    protected $casts = [
        'content' => 'array',
        'tags' => 'array',
        'another_articles' => 'array',
    ];

    public static function boot(): void
    {
        parent::boot();
        Model::unguard();
    }

    protected static function booted(): void
    {
    }

    public function getTags(): Collection|bool|array{
        if ($this->tagsCache){
            return $this->tagsCache;
        }else{
            if (isset($this->tags) && $this->tags){
                $this->tagsCache = Tag::getByIds($this->tags);
                return $this->tagsCache;
            }
        }

        return false;
    }

    public static function getByIds(array $ids): Collection|array{
        return self::query()
            ->whereIn('id',$ids)
            ->where('lang_locale','=',app()->currentLocale())
            ->where('active','=',1)
            ->get();
    }

    public function getContentTextShort():?string{
        if (isset($this->content['text'])){
            return Str::limit($this->content['text']);
        }
        return null;
    }

    public function getNameForSitemap(): string
    {
        $detailRoute = PageRoute::query()
            ->whereIn('route_name', ['article.detail', 'articles.detail', 'blog.detail'])
            ->orWhere(function ($q) {
                $q->where('route_controller', 'like', '%ArticlesController%')
                    ->where('route_action', 'like', '%detail%');
            })
            ->first();

        if ($detailRoute && $detailRoute->route_name) {
            // Always provide slug parameter so that any {slug} placeholder is replaced in the route path
            $params = ['slug' => $this->slug];
            return LocalizedRouteHelper::getPath($detailRoute->route_name, $params, $this->lang_locale);
        }

        // Fallback to a generic article path if route not found
        return rtrim(config('app.url'),'/').'/'.ltrim($this->lang_locale.'/'.$this->slug,'/');
    }

    public function getItemsForSitemap(string $locale): Collection|array
    {
        return self::query()
            ->where('lang_locale','=',$locale)
            ->where('active','=',1)
            ->get();
    }

}

