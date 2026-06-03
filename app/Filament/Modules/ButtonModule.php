<?php

namespace App\Filament\Modules;

use App\Models\PageRouteUrls;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;

class ButtonModule
{
    public static function getPageRouteUrlOptions(?string $locale = null): array
    {
        $query = PageRouteUrls::query()
            ->with('pageRoute:id,route_name')
            ->when(!blank($locale), fn ($q) => $q->where('locale', $locale));

        return $query
            ->get(['id', 'slug', 'page_route_id'])
            ->mapWithKeys(function (PageRouteUrls $pageRouteUrl): array {
                $routeName = $pageRouteUrl->pageRoute?->route_name;
                $slug = $pageRouteUrl->getAttribute('slug');
                $id = (string) $pageRouteUrl->getKey();
                $label = trim(($routeName ? ($routeName . ' - ') : '') . ($slug ?? ''));

                return [
                    $id => ($label !== '' ? $label : ('#' . $id)),
                ];
            })
            ->all();
    }

    public static function getDefinition(string $arrayToSaveName, string $label = 'Tlačítko', ?string $locale = null): Fieldset
    {
        return Fieldset::make($label)->schema([
            TextInput::make($arrayToSaveName . '.buttonText')->label('Text v tlačítku'),
            Select::make($arrayToSaveName . '.buttonLink.pageRouteUrl')
                ->label('Vyberte stránku')
                ->options(function (Get $get) use ($locale): array {
                    $currentLocale = $locale;

                    if (blank($currentLocale)) {
                        $currentLocale = $get('lang_locale');
                    }

                    return self::getPageRouteUrlOptions(
                        blank($currentLocale) ? null : (string) $currentLocale
                    );
                })
                ->formatStateUsing(fn ($state) => is_array($state) ? ($state['id'] ?? $state['value'] ?? null) : $state)
                ->searchable()
                ->preload()
                ->default(null)
                ->placeholder('— vyberte stránku —'),
            TextInput::make($arrayToSaveName . '.buttonLink.slug')
                ->label('Odkaz v tlačítku')
                ->helperText('Zadejte slug pro odkaz (volitelné)'),
            Checkbox::make($arrayToSaveName . '.buttonLink.is_external')
                ->label('Externí odkaz')
                ->extraAttributes(['class' => 'flex items-center']),
        ]);
    }
}
