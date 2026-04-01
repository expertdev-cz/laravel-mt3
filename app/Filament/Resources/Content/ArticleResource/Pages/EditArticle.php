<?php

namespace App\Filament\Resources\Content\ArticleResource\Pages;

use App\Filament\Resources\Content\ArticleResource;
use App\Helpers\RichEditorHelper;
use App\Models\PageRouteUrls;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;
use App\Models\System\PageRoute;

class EditArticle extends EditRecord
{
    protected static ?string $title = 'Editace článku';
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->requiresConfirmation()
                    ->after(function () {
                        $this->clearArticleCachesOnRemoval();
                    }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function afterSave(): void
    {
        try {
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
                PageRouteUrls::query()->updateOrCreate([
                    'page_route_id' => $detailRoute->id,
                    'slug' => $this->record->slug,
                    'locale' => $this->record->lang_locale,
                ]);

                // Invalidate cached list so middleware recognizes updated/created URL
                Cache::forget('page_route_urls_definitions');

                if ($this->record->wasChanged('slug')) {
                    $originalSlug = (string) $this->record->getOriginal('slug');
                    if (!empty($originalSlug)) {
                        if ($originalSlug !== $this->record->slug) {
                            PageRouteUrls::query()
                                ->where('page_route_id', $detailRoute->id)
                                ->where('slug', $originalSlug)
                                ->where('locale', $this->record->lang_locale)
                                ->delete();
                            // Invalidate cached list after removing old URL
                            Cache::forget('page_route_urls_definitions');
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('Route URL sync failed for article ID: ' . ($this->record->id ?? 'null') . ' — ' . $e->getMessage());
        }
    }

    protected function afterDelete(): void
    {
        $this->clearArticleCachesOnRemoval();
    }

    protected function afterForceDelete(): void
    {
        $this->clearArticleCachesOnRemoval();
    }

    private function clearArticleCachesOnRemoval(): void
    {
        try {
            $record = $this->record;

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

            $detailRoute = $detailRoutes->get($record->lang_locale) ?: $detailRoutes->first();

            if ($detailRoute && $detailRoute->route_name) {
                PageRouteUrls::query()
                    ->where('page_route_id', $detailRoute->id)
                    ->where('slug', $record->slug)
                    ->where('locale', $record->lang_locale)
                    ->delete();
            }
            Cache::forget('page_route_urls_definitions');
        } catch (\Throwable $e) {
            \Log::warning('Route URL cleanup failed for article ID (delete): ' . ($this->record->id ?? 'null') . ' — ' . $e->getMessage());
        }
    }
}
