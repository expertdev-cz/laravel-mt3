<?php

namespace App\Filament\Resources\Content\ArticleResource\Pages;

use App\Filament\Resources\Content\ArticleResource;
use App\Models\PageRouteUrls;
use App\Helpers\RichEditorHelper;
use App\Models\System\PageRoute;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;

class CreateArticle extends CreateRecord
{
    protected static ?string $title = 'Vytvoření článku';
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        [$processedData, $hasMissingCaptions, $missingCount] = RichEditorHelper::processArticleContent($data);

        if ($hasMissingCaptions) {
            Notification::make()
                ->warning()
                ->title('Chybí popisky obrázků')
                ->body("Některé obrázky nemají vyplněný popisek (caption). Celkem: {$missingCount} " . ($missingCount === 1 ? 'obrázek' : ($missingCount < 5 ? 'obrázky' : 'obrázků')) . ". Pro lepší SEO doporučujeme přidat popisky ke všem obrázkům.")
                ->persistent()
                ->send();
        }

        return $processedData;
    }

    public function afterCreate(): void
    {
        try {
            // Select the matching detail route for the record locale (fallback to any if not found)
            $detailRoutes = PageRoute::query()
                ->where(function ($q) {
                    $q->whereIn('route_name', ['article.detail', 'articles.detail', 'blog.detail'])
                      ->orWhere(function ($q2) {
                          $q2->where('route_controller', 'like', '%ArticlesController%')
                             ->where('route_action', 'like', '%detail%');
                      });
                })
                ->where('is_active', true)
                ->get()
                ->keyBy('route_lang');

            $detailRoute = $detailRoutes->get($this->record->lang_locale) ?: $detailRoutes->first();

            if ($detailRoute && $detailRoute->route_name) {
                PageRouteUrls::query()->create([
                    'page_route_id' => $detailRoute->id,
                    'slug' => $this->record->slug,
                    'locale' => $this->record->lang_locale,
                ]);

                // Invalidate cached list of PageRouteUrls so middleware picks up new URL
                Cache::forget('page_route_urls_definitions');
            }
        } catch (\Throwable $e) {
            \Log::warning('Route URL sync failed for article ID (create): ' . ($this->record->id ?? 'null') . ' — ' . $e->getMessage());
        }
    }
}
