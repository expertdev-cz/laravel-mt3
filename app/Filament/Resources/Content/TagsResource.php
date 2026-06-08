<?php

namespace App\Filament\Resources\Content;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use App\Filament\Modules\BaseSettingsModule;
use App\Filament\Resources\Content\TagsResource\Pages;
use App\Filament\Resources\Content\TagsResource\RelationManagers;
use App\Models\Content\Tag;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TagsResource extends Resource
{
    protected static ?string $model = Tag::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Články';
    protected static bool $shouldRegisterNavigation = false;

    public static function canViewAny(): bool { return false; }
    protected static ?int $navigationSort = 20;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Tagy';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema(array_merge(BaseSettingsModule::getDefinitionSlugTitleLang('','name','Tag')));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Jméno'),
                TextColumn::make('slug')->label('Link'),
                CheckboxColumn::make('active')->label('Aktivní'),
            ])
            ->filters([
                //
            ])
            ->actions([
                DeleteAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTags::route('/create'),
            'edit' => Pages\EditTags::route('/{record}/edit'),
        ];
    }
}
