<?php
declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class SeoBlock extends Component
{
    /** @var array<string,mixed> */
    public array $seo = [];

    /** @var mixed */
    public $seoItem = null;

    public ?string $updatedAtIso = null;

    /**
     * @param array<string,mixed>|null $seo
     * @param mixed $seoItem
     */
    public function __construct(?array $seo = null, $seoItem = null)
    {
        $this->seoItem = $seoItem;
        $incomingSeo   = $seo ?? [];

        // 1) Načtení SEO dat z $seoItem (model nebo pole)
        if ($seoItem) {
            if (is_object($seoItem)) {
                $modelSeo = (array) data_get($seoItem, 'seo', []);

                if (empty($modelSeo)) {
                    if ($seoItem instanceof Arrayable) {
                        $modelSeo = Arr::only($seoItem->toArray(), $this->seoKeys());
                    } elseif (method_exists($seoItem, 'toArray')) {
                        $modelSeo = Arr::only($seoItem->toArray(), $this->seoKeys());
                    }
                }

                $incomingSeo = array_replace($incomingSeo, $modelSeo);
                $this->updatedAtIso = $this->isoFrom($seoItem->updated_at ?? null);
            } elseif (is_array($seoItem)) {
                $modelSeo = (array) ($seoItem['seo'] ?? $seoItem);
                $incomingSeo = array_replace($incomingSeo, $modelSeo);
                $this->updatedAtIso = $this->isoFrom($seoItem['updated_at'] ?? null);
            }
        }

        $this->seo = $incomingSeo;
    }

    public function render(): View|Closure|string
    {
        return view('components.seo-block', [
            'seo'          => $this->seo,
            'updatedAtIso' => $this->updatedAtIso,
        ]);
    }

    /** @return string[] */
    private function seoKeys(): array
    {
        return [
            'title','keywords','desc','robots','canonical_URL',
            'og_type','og_title','og_desc','og_image',
            'twitter_title','twitter_desc','twitter_image',
            'hreflang','external',
        ];
    }

    private function isoFrom(mixed $value): ?string
    {
        if (!$value) {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format(DATE_ATOM);
        }

        try {
            return Carbon::parse((string) $value)->toIso8601String();
        } catch (\Throwable) {
            return null;
        }
    }
}
