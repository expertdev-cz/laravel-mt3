<?php

namespace App\Filament\Resources\System;

use Filament\Actions\EditAction;
use App\Filament\Resources\System\SettingsResource\Pages;
use App\Filament\Resources\System\SettingsResource\RelationManagers;
use App\Models\System\Settings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingsResource extends Resource
{
    protected static ?string $model = Settings::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Nastavení webu';
    protected static ?int $navigationSort = 30;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Nastavení webu';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('content.webName')->label('Název webu'),
                TextInput::make('content.mailContactForm')->required()->label('Email pro kontaktní formulář')->email(),

                Textarea::make('content.robots')->label('Obsah robots.txt'),
                Textarea::make('content.externalCode')->label('Externí nástroje (GA)'),
                FileUpload::make('content.favicon')->label('Favicon')->image()->automaticallyResizeImagesToHeight(64),
                FileUpload::make('content.logo')->label('Logo')->image(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextInputColumn::make('content.webName')->label('Název webu'),
                TextInputColumn::make('content.mailContactForm')->label('Email pro kontaktní formulář')->rules(['email']),
                TextColumn::make('content.robots')
                    ->label('Obsah robots.txt'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([

            ])->paginated(false);
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
            'index' => Pages\ListSettings::route('/'),
            'edit' => Pages\EditSettings::route('/{record}/edit'),
        ];
    }
}
