<?php

namespace App\Filament\Resources\System;

use Filament\Actions\EditAction;
use App\Filament\Resources\System\LanguageResource\Pages;
use App\Filament\Resources\System\LanguageResource\RelationManagers;
use App\Models\System\Language;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Nastavení webu';
    protected static ?int $navigationSort = 10;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-language';
    protected static ?string $navigationLabel = 'Jazyky';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')->required(),
                Select::make('locale')
                    ->options(collect(Language::getAllowedLanguageLocale())->map(fn ($lang) => [$lang => $lang])->toArray())
                    ->required(),
                Checkbox::make('active'),
                Checkbox::make('default')->label('Default lang'),
                FileUpload::make('icon')->image()
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('locale'),
                CheckboxColumn::make('active'),
                CheckboxColumn::make('default')->disabled(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
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
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}
