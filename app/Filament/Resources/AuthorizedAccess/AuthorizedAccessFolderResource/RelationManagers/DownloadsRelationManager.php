<?php

namespace App\Filament\Resources\AuthorizedAccess\AuthorizedAccessFolderResource\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DownloadsRelationManager extends RelationManager
{
    protected static string $relationship = 'downloads';
    protected static ?string $title = 'Soubory';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                RichEditor::make('category')
                    ->label('Kategorie')
                    ->helperText('Nadpis skupiny, např. „Citylighty řady <strong>Poster</strong>"')
                    ->toolbarButtons(['bold', 'italic'])
                    ->columnSpanFull(),
                TextInput::make('code')->label('Kód'),
                TextInput::make('title')->label('Název')->required(),
                Toggle::make('is_active')->label('Aktivní')->default(true),
                FileUpload::make('file')
                    ->label('Soubor')
                    ->disk('public')
                    ->directory('authorized-access')
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category')->label('Kategorie')->html()->limit(50),
                TextColumn::make('code')->label('Kód'),
                TextColumn::make('title')->label('Název')->searchable(),
                CheckboxColumn::make('is_active')->label('Aktivní'),
            ])
            ->reorderable('sort')
            ->defaultSort('sort')
            ->headerActions([
                CreateAction::make()->label('Přidat soubor'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()->requiresConfirmation(),
            ])
            ->bulkActions([]);
    }
}
