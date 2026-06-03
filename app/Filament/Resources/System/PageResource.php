<?php

namespace App\Filament\Resources\System;

use App\Filament\Modules\BaseSettingsModule;
use App\Filament\Modules\PageTypes\AboutUsPageType;
use App\Filament\Modules\PageTypes\HomepagePageType;
use App\Filament\Modules\PageTypes\ArticlesPageType;
use App\Filament\Modules\PageTypes\ContactPageType;
use App\Filament\Modules\PageTypes\ReferenceDetailPageType;
use App\Filament\Modules\PageTypes\ReferencesPageType;
use App\Filament\Modules\PageTypes\TechnologiesPageType;
use App\Filament\Modules\PageTypes\TextPageType;
use App\Filament\Modules\SeoModule;
use App\Filament\Resources\System\PageResource\Pages;
use App\Models\System\Page;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Resources\Resource;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Obsah webu';
    protected static ?int $navigationSort = 55;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Stránky';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                BaseSettingsModule::getDefinition(
                    showPageRouteField: true,
                ),

                Fieldset::make('Obsah')
                    ->schema([
                        Section::make()
                            ->schema(fn (Get $get): array => match ($get('type')) {
                                'homepage' => HomepagePageType::getDefinition(),
                                'articles' => ArticlesPageType::getDefinition(),
                                'contact' => ContactPageType::getDefinition(),
                                'about-us' => AboutUsPageType::getDefinition(),
                                'references' => ReferencesPageType::getDefinition(),
                                'reference-detail' => ReferenceDetailPageType::getDefinition(),
                                'technologies' => TechnologiesPageType::getDefinition(),
                                'text' => TextPageType::getDefinition(),
                                default => [],
                            })->key('dynamicTypeFields')
                    ])->columns(1),

                SeoModule::getDefinition(),

                Fieldset::make('Externí napojení')
                    ->schema([
                    RichEditor::make('seo.external')
                            ->default(''),
                    ])->columns(1),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Jméno')->searchable(),
                TextColumn::make('type')->label('Typ'),
                TextColumn::make('lang_locale')->label('Jazyk'),
                TextColumn::make('slug')->label('Link'),
                CheckboxColumn::make('active')->label('Aktivní'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('Zobrazit')
                    ->url(fn ($record) => url()->to($record->getNameForSitemap()))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-eye')
                    ->color('info'),

                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->after(function ($action, Page $record) {
                        Cache::forget('localized_pages_definitions');
                        Cache::forget('generated_routes_definitions');
                        Cache::forget('localized_routes_definitions');
                        Cache::forget('page_route_urls_definitions');
                        if ($record->url_type === 'external') {
                            Cache::forget('external_routes_definitions');
                        }
                        Artisan::call('route:clear');
                        Artisan::call('optimize:clear');
                    }),

                ReplicateAction::make()->before(function (ReplicateAction $action, Page $record) {
                    $record->slug .= '-copy-'.time();
                }),
            ])->bulkActions([ ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
