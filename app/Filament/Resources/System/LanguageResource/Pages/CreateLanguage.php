<?php

namespace App\Filament\Resources\System\LanguageResource\Pages;

use App\Filament\Resources\System\LanguageResource;
use App\Models\System\Language;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;

class CreateLanguage extends CreateRecord
{
    protected static ?string $title = 'Vytvoření jazyka';
    protected static string $resource = LanguageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (Language::count() === 0) {
            $data['default'] = true;
        }

        return $data;
    }

    protected function beforeCreate(): void
    {
        if (Language::query()->where('default', 1)->count() > 1 && $this->data['default']) {
            Notification::make()
                ->title('Only one language can be default')
                ->danger()
                ->send();

            $this->halt();
        }
    }

    protected function afterCreate(): void
    {
        Cache::forget('default_locale');
    }
}
