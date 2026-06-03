<?php

namespace App\Filament\Resources\AuthorizedAccess;

use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource\Pages\CreateAuthorizedAccessFolder;
use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource\Pages\EditAuthorizedAccessFolder;
use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource\Pages\ListAuthorizedAccessFolders;
use App\Models\AuthorizedAccess\AuthorizedAccessFolder;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuthorizedAccessFolderResource extends Resource
{
    protected static ?string $model = AuthorizedAccessFolder::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Autorizovaný přístup';
    protected static ?int $navigationSort = 20;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationLabel = 'AP složky';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')->label('Název')->required(),
                TextInput::make('slug')->label('Slug')->required(),
                Select::make('page_type')
                    ->label('Typ stránky')
                    ->options([
                        'authorized-access-home' => 'AP - Rozcestník',
                        'authorized-access-technical-sheets' => 'AP - Technické listy',
                    ])
                    ->required(),
                TextInput::make('sort')->label('Pořadí')->numeric()->default(0),
                Toggle::make('is_active')->label('Aktivní')->default(true),
                Textarea::make('description')->label('Popis')->rows(4)->columnSpanFull(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Název')->searchable(),
                TextColumn::make('page_type')->label('Typ stránky'),
                TextColumn::make('sort')->label('Pořadí'),
                CheckboxColumn::make('is_active')->label('Aktivní'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()->requiresConfirmation(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAuthorizedAccessFolders::route('/'),
            'create' => CreateAuthorizedAccessFolder::route('/create'),
            'edit' => EditAuthorizedAccessFolder::route('/{record}/edit'),
        ];
    }
}