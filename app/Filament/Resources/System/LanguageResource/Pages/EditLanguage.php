<?php

namespace App\Filament\Resources\System\LanguageResource\Pages;

use App\Filament\Resources\System\LanguageResource;
use App\Models\System\Language;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class EditLanguage extends EditRecord
{
    protected static ?string $title = 'Editace jazyka';
    protected static string $resource = LanguageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->before(function () {
                    if (Language::count() === 1) {
                        Notification::make()
                            ->title('Cannot delete language')
                            ->body('This is the only language in the system, so it cannot be deleted.')
                            ->danger()
                            ->send();

                        $this->halt();
                    }

                    if ($this->record->default) {
                        Notification::make()
                            ->title('Cannot delete default language')
                            ->body('The default language cannot be deleted. Please set another language as default first.')
                            ->danger()
                            ->send();

                        $this->halt();
                    }
                }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (Language::count() === 1 && $this->record->default) {
            $data['default'] = true;
        }

        return $data;
    }

    protected function beforeSave(): void
    {
        if (Language::count() === 1 && $this->record->default && !$this->data['default']) {
            $this->data['default'] = true;
            Notification::make()
                ->title('Default language cannot be changed')
                ->body('This is the only language in the system, so it must remain as default.')
                ->warning()
                ->send();
        }

        if (Language::query()->where('default', 1)->count() > 1 && $this->data['default']) {
            Notification::make()
                ->title('Only one language can be default')
                ->danger()
                ->send();

            $this->halt();
        }

        if ($this->data['default'] && !$this->record->default) {
            Language::where('default', true)->update(['default' => false]);
        }
    }

    protected function afterSave(): void
    {
        Cache::forget('default_locale');
    }
}
