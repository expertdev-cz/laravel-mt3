<?php

namespace App\Filament\Resources\AuthorizedAccess;

use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessDownloadResource\Pages\CreateAuthorizedAccessDownload;
use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessDownloadResource\Pages\EditAuthorizedAccessDownload;
use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessDownloadResource\Pages\ListAuthorizedAccessDownloads;
use App\Models\AuthorizedAccess\AuthorizedAccessDownload;
use App\Models\AuthorizedAccess\AuthorizedAccessFolder;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuthorizedAccessDownloadResource extends Resource
{
    protected static ?string $model = AuthorizedAccessDownload::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Autorizovaný přístup';
    protected static ?int $navigationSort = 30;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-arrow-down';
    protected static ?string $navigationLabel = 'AP soubory';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('folder_id')
                    ->label('Složka')
                    ->options(AuthorizedAccessFolder::query()->orderBy('title')->pluck('title', 'id'))
                    ->required(),
                TextInput::make('code')->label('Kód'),
                TextInput::make('title')->label('Název')->required(),
                TextInput::make('sort')->label('Pořadí')->numeric()->default(0),
                Toggle::make('is_active')->label('Aktivní')->default(true),
                FileUpload::make('file')
                    ->label('Soubor')
                    ->disk('public')
                    ->directory('authorized-access')
                    ->columnSpanFull(),
                Textarea::make('description')->label('Popis')->rows(4)->columnSpanFull(),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('folder.title')->label('Složka'),
                TextColumn::make('code')->label('Kód'),
                TextColumn::make('title')->label('Název')->searchable(),
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
            'index' => ListAuthorizedAccessDownloads::route('/'),
            'create' => CreateAuthorizedAccessDownload::route('/create'),
            'edit' => EditAuthorizedAccessDownload::route('/{record}/edit'),
        ];
    }
}