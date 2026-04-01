<?php

namespace App\Models\System;

use App\Helpers\FunctionsHelper;
use App\Helpers\LocalizedRouteHelper;
use App\Interfaces\System\SitemapItem;
use App\Models\PageRouteUrls;
use App\Models\System\PageRoute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 *
 *
 * @property int $id
 * @property string $slug
 * @property string $lang_locale
 * @property int|null $parent_id
 * @property string $type
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $title_media_json
 * @property array|null $content
 * @property int $active
 * @property array|null $seo
 * @property int|null $in_menu
 * @property int|null $in_footer_menu
 * @property int|null $in_menu_only_for_logged
 * @property int|null $in_menu_order
 * @property string|null $in_menu_title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\System\Language|null $language
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 * @method static Builder|Page whereActive($value)
 * @method static Builder|Page whereContent($value)
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereInFooterMenu($value)
 * @method static Builder|Page whereInMenu($value)
 * @method static Builder|Page whereInMenuOnlyForLogged($value)
 * @method static Builder|Page whereInMenuOrder($value)
 * @method static Builder|Page whereInMenuTitle($value)
 * @method static Builder|Page whereLangLocale($value)
 * @method static Builder|Page whereParentId($value)
 * @method static Builder|Page whereSeo($value)
 * @method static Builder|Page whereSlug($value)
 * @method static Builder|Page whereSubtitle($value)
 * @method static Builder|Page whereTitle($value)
 * @method static Builder|Page whereTitleMediaJson($value)
 * @method static Builder|Page whereType($value)
 * @method static Builder|Page whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Page extends Model implements SitemapItem
{
    use HasFactory;

    protected $casts = [
        'content' => 'array',
        'seo'=> 'array',
    ];

    public static function boot(): void
    {
        parent::boot();
        Model::unguard();
    }

    protected static function booted(): void
    {
    }

    public function language(): HasOne
    {
        return $this->hasOne(Language::class);
    }

    public function pageRoute(): BelongsTo
    {
        return $this->belongsTo(PageRoute::class);
    }

    public function pageRouteUrls(): HasMany
    {
        return $this->hasMany(PageRouteUrls::class, 'page_id');
    }

    public function getNameForSitemap(): string{
        // Try to build URL via routes system
        $this->loadMissing('pageRoute');
        $route = $this->pageRoute;
        if ($route && $route->route_name){
            $params = [];
            if ($route->disable_auto_route){
                // fetch localized slug if available
                $localizedSlug = $this->pageRouteUrls()
                    ->where('locale', $this->lang_locale)
                    ->value('slug');
                $params = [($localizedSlug ?: $this->slug)];
            }
            return LocalizedRouteHelper::getPath($route->route_name, $params, $this->lang_locale);
        }

        // Fallbacks
        if (Str::startsWith($this->slug, ['http://','https://'])){
            return $this->slug;
        }
        return $this->slug; // SeoService will prepend APP_URL
    }

    public function getItemsForSitemap(string $locale): Collection|array{
        return self::query()
            ->with(['pageRoute','pageRouteUrls'])
            ->where('lang_locale','=',$locale)
            ->where('active','=',1)
            ->get();
    }

    public function getReviewsIds(): array{
        if (isset($this->content['reviews'])){
            //return $this->content['reviews'];
            return FunctionsHelper::mapIterableToId($this->content['reviews']);
        }
        return [];
    }

    public function getReferencesIds(): array{
        if (isset($this->content['references'])){
            //return $this->content['references'];
            return FunctionsHelper::mapIterableToId($this->content['references']);
        }
        return [];
    }

    public function getPackagesIds(): array{
        if (isset($this->content['packages'])){
            return FunctionsHelper::mapIterableToId($this->content['packages']);
        }
        return [];
    }

}
