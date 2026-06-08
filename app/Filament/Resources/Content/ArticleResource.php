<?php

namespace App\Filament\Resources\Content;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use App\Filament\Modules\BaseSettingsModule;
use App\Filament\Modules\ImageModule;
use App\Filament\Resources\Content\ArticleResource\Pages;
use App\Models\Content\Tag;
use App\Models\Content\Article;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Fieldset;
use Filament\Resources\Resource;
use Filament\Actions\ReplicateAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Články';
    protected static ?int $navigationSort = 10;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Články';
    protected static bool $shouldRegisterNavigation = false;

    public static function canViewAny(): bool { return false; }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema(self::getFormSchema())
            ->columns(1);
    }

    protected static function getFormSchema(): array
    {
        return [
            Fieldset::make('Základní nastavení')
                ->schema(BaseSettingsModule::getDefinitionSlugTitleLang(''))
                ->columns(4),

            Fieldset::make('Obsah článku')
                ->schema([
                    ImageModule::getDefinition('content.image', 'Obrázek'),
                    Select::make('tags')
                        ->label('Tagy')
                        ->multiple()
                        ->options(Tag::whereActive(1)->orderBy('name')->pluck('name', 'id'))
                        ->columnSpanFull(),

                    RichEditor::make('content.text')
                        ->label('Text článku')
                        ->required()
                        ->columnSpanFull(),
                ])
                ->columns(1),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->formatStateUsing(function (string $state): string {
                        if (strlen($state) > 32) {
                            return substr($state, 0, 32) . '...';
                        }
                        return $state;
                    })
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        
                        if (strlen($state) > 32) {
                            return $state;
                        }
                        
                        return null;
                    }),
                TextColumn::make('lang_locale')->label('Jazyk'),
                TextColumn::make('slug')->label('Link')
                ->formatStateUsing(function (string $state): string {
                        if (strlen($state) > 40) {
                            return substr($state, 0, 40) . '...';
                        }
                        return $state;
                    })
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        
                        if (strlen($state) > 40) {
                            return $state;
                        }
                        
                        return null;
                    }),
                CheckboxColumn::make('active')->label('Aktivní'),
                TextColumn::make('publish_time')->label('Datum publikace'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation(),
                ReplicateAction::make()->before(function (ReplicateAction $action, Article $record) {
                    $record->slug .= '-copy-'.time();
                }),
            ])
            ->bulkActions([ ]);
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
