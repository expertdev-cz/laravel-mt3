<?php

namespace App\Filament\Modules;

use App\Helpers\PageTypesHelper;
use App\Models\System\Language;
use App\Models\System\PageRoute;
use App\Services\System\UrlService;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class BaseSettingsModule
{
    public static function getDefinition(
        string $slugHint = 'Url stránky v rámci webu',
        string $titleName = 'title',
        string $titleLabel = 'Nadpis',
        bool $showPageRouteField = false
    ): Fieldset {
        $schema = self::getDefinitionSlugTitleLang($slugHint, $titleName, $titleLabel, requireSlug: ! $showPageRouteField);

        if ($showPageRouteField) {
            $schema = array_merge($schema, [
                Hidden::make('show_slug')
                    ->default(false)
                    ->dehydrated(false),

                Group::make([
                    Select::make('type')
                        ->options(PageTypesHelper::$pageTypesLabels)
                        ->required()
                        ->label('Typ stránky')
                        ->live()
                        ->afterStateUpdated(function (Select $component, callable $set, ?string $state) {
                            if ($section = $component->getContainer()->getComponent('dynamicTypeFields')) {
                                $section->getChildComponentContainer()->fill();
                            }
                            if ($state) {
                                try {
                                    $container = $component->getContainer();
                                    $pageRouteField = null;
                                    foreach ($container->getComponents() as $formComponent) {
                                        if ($formComponent instanceof Component && $formComponent->getName() === 'page_route_id') {
                                            $pageRouteField = $formComponent;
                                            break;
                                        }
                                    }
                                    if ($pageRouteField) {
                                        $matchingRoute = PageRoute::where('is_active', 1)
                                            ->where('template', $state)
                                            ->first();
                                        if ($matchingRoute) {
                                            $set('page_route_id', $matchingRoute->id);
                                        }
                                    }
                                } catch (\Exception $e) {}
                            }
                        })
                        ->disabledOn('edit')
                        ->columnSpan(1),

                    Select::make('url_type')
                        ->label('URL typ')
                        ->options([
                            'internal' => 'Interní',
                            'external' => 'Externí',
                        ])
                        ->default('internal')
                        ->live()
                        ->afterStateUpdated(function (callable $get, callable $set, $state) {
                            if ($state === 'external') {
                                $set('page_route_id', null);
                                $set('show_slug', true);
                            } else {
                                $set('show_slug', false);
                            }
                        })
                        ->columnSpan(1),

                    Select::make('page_route_id')
                        ->label('Page Route')
                        ->options(fn () => PageRoute::query()->where('is_active', 1)->pluck('route_name', 'id'))
                        ->searchable()
                        ->placeholder('Select a page route (required if slug is empty)')
                        ->nullable()
                        ->requiredWithout('slug')
                        ->live()
                        ->visible(fn (callable $get) => $get('url_type') === 'internal')
                        ->disabled(function ($record) {
                            if ($record && $record->id) {
                                return PageRoute::where('page_id', $record->id)->exists();
                            }
                            return false;
                        })
                        ->afterStateUpdated(function (callable $get, callable $set, $state) {
                            if ($state) {
                                $route = PageRoute::find($state);
                                if ($route && $route->disable_auto_route) {
                                    $set('show_slug', true);
                                } else {
                                    $set('show_slug', false);
                                    $set('slug', null);
                                }
                            }
                        })
                        ->columnSpan(1),
                ])
                ->columns(3)
                ->columnSpanFull()
            ]);
        }

        return Fieldset::make('Základní nastavení')
            ->schema($schema)
            ->columns(3);
    }

    public static function getDefinitionSlugTitleLang(
        string $slugHint = 'Url stránky v rámci webu',
        string $titleName = 'title',
        string $titleLabel = 'Nadpis',
        ?string $setSlugToField = 'slug',
        ?string $setToField = null,
        bool $requireSlug = true,
    ): array {
        $titleComponent = TextInput::make($titleName)
            ->required()
            ->label($titleLabel)
            ->live(debounce: 1000);

        if ($setToField) {
            $titleComponent->afterStateUpdated(fn (callable $set, ?string $state) => $set($setToField, $state));
        }

        if ($setSlugToField) {
            $titleComponent->afterStateUpdated(fn (callable $set, ?string $state) => $set($setSlugToField, Str::slug((string) $state)));
        }

        $slug = TextInput::make('slug')
            ->hint($slugHint)
            ->rules([
                function () {
                    return function (string $attribute, $value, \Closure $fail) {
                        // Získáme data z formuláře
                        $data = request()->all();
                        $langLocale = $data['lang_locale'] ?? null;
                        $pageRouteId = $data['page_route_id'] ?? null;
                        $recordId = request()->route('record'); // ID editovaného záznamu
                        
                        if (!$langLocale || !$value || !$pageRouteId) {
                            return;
                        }
                        
                        // Načteme page_route a zjistíme disable_auto_route a route_path
                        $pageRoute = PageRoute::find($pageRouteId);
                        if (!$pageRoute) {
                            return;
                        }
                        
                        $query = \App\Models\System\Page::where('slug', $value)
                            ->where('lang_locale', $langLocale);
                        
                        // Vynecháme aktuální záznam při editaci
                        if ($recordId) {
                            $query->where('id', '!=', $recordId);
                        }
                        
                        if ($pageRoute->disable_auto_route == 1) {
                            // Přímá URL - kontroluj všechny stránky se stejným slugem,
                            // které mají disable_auto_route = 1 A STEJNÝ route_path
                            $routePath = $pageRoute->route_path;
                            
                            $conflictExists = $query->whereHas('pageRoute', function($q) use ($routePath) {
                                $q->where('disable_auto_route', 1)
                                  ->where('route_path', $routePath);
                            })->exists();
                            
                            if ($conflictExists) {
                                $fail('Stránka se stejným slugem již existuje na jiné route se stejnou URL strukturou.');
                            }
                        } else {
                            // Parametrická route - kontroluj jen v rámci stejné page_route
                            $conflictExists = $query->where('page_route_id', $pageRouteId)->exists();
                            
                            if ($conflictExists) {
                                $fail('Stránka se stejným slugem již existuje v této route.');
                            }
                        }
                    };
                }
            ])
            ->label('Link')
            ->helperText('Změnou slug se upraví i jiné podstránky na kterých je přiřazená tato route')
            ->reactive()
            ->afterStateUpdated(function (callable $get, callable $set, ?string $state) {
                if (filled($get('seo.canonical_URL'))) {
                    return; // uživatel už vyplnil ručně
                }
                if ($get('url_type') === 'external' || blank($state)) {
                    return;
                }

                $base = rtrim((string) config('app.url'), '/');
                $canonical = $base . '/' . ltrim((string) $state, '/');

                $set('seo.canonical_URL', $canonical);
            });

        if ($requireSlug) {
            $slug->required();
        } else {
            $slug->requiredWithout('page_route_id');
        }

        return [
            $titleComponent,
            $slug,

            Select::make('lang_locale')
                ->options(Language::whereActive(1)->get(['locale', 'name'])->pluck('name', 'locale'))
                ->default(UrlService::defaultLang())
                ->label('Jazyk')
                ->required(),

            Checkbox::make('active')
                ->default(1)
                ->label('Je aktivní'),
        ];
    }
}
