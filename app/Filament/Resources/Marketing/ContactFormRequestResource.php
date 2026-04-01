<?php

namespace App\Filament\Resources\Marketing;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use App\Filament\Resources\Marketing\ContactFormRequestResource\Pages;
use App\Filament\Resources\Marketing\ContactFormRequestResource\RelationManagers;
use App\Models\Marketing\ContactFormRequest;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactFormRequestResource extends Resource
{
    protected static ?string $model = ContactFormRequest::class;

    protected static string|\UnitEnum|null $navigationGroup = 'E-mailové schránky';
    protected static ?int $navigationSort = 30;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-inbox';
    protected static ?string $navigationLabel = 'Přijaté dotazy';

    /**
     * Badge s počtem nepřečtených zpráv v navigaci
     */
    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::unread()->count();
        return $count > 0 ? (string) $count : null;
    }

    /**
     * Barva badge
     */
    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Checkbox::make('is_read')
                    ->label('Přečteno'),
                TextInput::make('name')->label('Jméno')->readOnly(),
                TextInput::make('email')->label('Email')->readOnly(),
                TextInput::make('phone')->label('Telefon')->readOnly(),
                Textarea::make('content')->label('Dotaz')->readOnly(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CheckboxColumn::make('is_read')
                    ->label('Přečteno')
                    ->afterStateUpdated(function ($record, $state) {
                        $record->update(['read_at' => $state ? now() : null]);
                    }),
                TextColumn::make('name')->label('Jméno')
                    ->weight(fn ($record) => $record->is_read ? 'normal' : 'bold'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('phone')->label('Telefon'),
                TextColumn::make('content')->label('Dotaz')->limit(50),
                TextColumn::make('created_at')->label('Přijato')->dateTime('d.m.Y H:i')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('is_read')
                    ->label('Stav')
                    ->placeholder('Všechny')
                    ->trueLabel('Přečtené')
                    ->falseLabel('Nepřečtené'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('markAsRead')
                        ->label('Označit jako přečtené')
                        ->icon('heroicon-o-envelope-open')
                        ->action(fn ($records) => $records->each->update(['is_read' => true, 'read_at' => now()])),
                    BulkAction::make('markAsUnread')
                        ->label('Označit jako nepřečtené')
                        ->icon('heroicon-o-envelope')
                        ->action(fn ($records) => $records->each->update(['is_read' => false, 'read_at' => null])),
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
            'index' => Pages\ListContactFormRequests::route('/'),
            'create' => Pages\CreateContactFormRequest::route('/create'),
            'edit' => Pages\EditContactFormRequest::route('/{record}/edit'),
        ];
    }
}
