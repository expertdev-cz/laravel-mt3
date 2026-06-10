<?php

namespace App\Filament\Resources\AuthorizedAccess;

use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource\Pages\CreateAuthorizedAccessFolder;
use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource\Pages\EditAuthorizedAccessFolder;
use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource\Pages\ListAuthorizedAccessFolders;
use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource\RelationManagers\DownloadsRelationManager;
use App\Models\AuthorizedAccess\AuthorizedAccessFolder;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

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
                TextInput::make('title')
                    ->label('Nadpis (hero)')
                    ->required()
                    ->live(debounce: 800)
                    ->afterStateUpdated(function (callable $set, ?string $state, string $operation) {
                        if ($operation === 'create') {
                            $set('slug', Str::slug((string) $state));
                        }
                    }),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Textarea::make('subtitle')
                    ->label('Podnadpis (hero)')
                    ->rows(2)
                    ->columnSpanFull(),
                Toggle::make('is_active')->label('Aktivní')->default(true),
                Hidden::make('page_type')->default('authorized-access-technical-sheets'),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Název')->searchable(),
                CheckboxColumn::make('is_active')->label('Aktivní'),
            ])
            ->reorderable('sort')
            ->defaultSort('sort')
            ->actions([
                EditAction::make(),
                DeleteAction::make()->requiresConfirmation(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            DownloadsRelationManager::class,
        ];
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