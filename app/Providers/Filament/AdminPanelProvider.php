<?php

namespace App\Providers\Filament;

use App\Models\PageRouteUrls;
use App\Models\System\Language;
use App\Models\System\PageRoute;
use Awcodes\Curator\CuratorPlugin;
use Awcodes\Curator\Resources\MediaResource;
use Datlechin\FilamentMenuBuilder\FilamentMenuBuilderPlugin;
use Datlechin\FilamentMenuBuilder\MenuPanel\ModelMenuPanel;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function boot(){
        Filament::serving(function () {
            Filament::registerRenderHook(
                'panels::user-menu.before', // Přidá tlačítko vedle loga v horním panelu
                fn () => view('filament.show-web-btn')
            );
        });
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => [
                    50 => 'oklch(0.977 0.021 10.508)',
                    100 => 'oklch(0.950 0.049 10.508)',
                    200 => 'oklch(0.905 0.095 10.508)',
                    300 => 'oklch(0.840 0.159 10.508)',
                    400 => 'oklch(0.753 0.226 10.508)',
                    500 => 'oklch(0.683 0.255 10.508)',
                    600 => 'oklch(0.639 0.255 10.508)',
                    700 => 'oklch(0.515 0.224 10.508)',
                    800 => 'oklch(0.446 0.185 10.508)',
                    900 => 'oklch(0.395 0.149 10.508)',
                    950 => 'oklch(0.278 0.107 10.508)',
                ],
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()->label('Články'),
                NavigationGroup::make()->label('Obsah webu'),
                NavigationGroup::make()->label('E-mailové schránky'),
                NavigationGroup::make()->label('Nastavení webu'),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                CuratorPlugin::make()
                    ->navigationGroup('Obsah webu')
                    ->label('Media')
                    ->navigationIcon('heroicon-o-photo')
                    ->navigationSort(25),
                FilamentMenuBuilderPlugin::make()
                    ->addLocations($this->getMenuLocations())
                    ->addMenuPanel(ModelMenuPanel::make('Routy stránek')->model(PageRoute::class))
                    ->addMenuPanel(ModelMenuPanel::make('URL rout stránek')->model(PageRouteUrls::class))
                    ->showCustomLinkPanel(true)
                    ->navigationGroup('Nastavení webu')
                    ->navigationLabel('Menu')
                    ->navigationIcon('heroicon-o-list-bullet')
                    ->navigationSort(15)
                    ->addMenuItemFields([
                        Select::make('lang_locale')
                            ->label('Jazyková mutace')
                            ->options(fn () => Language::query()
                                ->where('active', 1)
                                ->orderBy('id')
                                ->pluck('name', 'locale')
                                ->toArray())
                            ->default(fn () => app()->getLocale())
                            ->required(),
                    ])
            ])

            ->viteTheme('resources/css/filament/admin/theme.css');
    }

    private function getMenuLocations(): array
    {
        if (!Schema::hasTable('languages')) {
            return [
                'header-cs' => 'Header (CS)',
                'header-en' => 'Header (EN)',
            ];
        }

        $locales = Language::query()
            ->where('active', 1)
            ->orderBy('id')
            ->pluck('locale')
            ->toArray();

        if (empty($locales)) {
            $locales = ['cs', 'en'];
        }

        $locations = [];

        foreach ($locales as $locale) {
            $key = 'header-' . $locale;
            $locations[$key] = 'Header (' . strtoupper($locale) . ')';
        }

        return $locations;
    }
}
