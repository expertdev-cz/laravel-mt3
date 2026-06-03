<?php

namespace App\Filament\Resources\AuthorizedAccess;

use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessUserResource\Pages\CreateAuthorizedAccessUser;
use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessUserResource\Pages\EditAuthorizedAccessUser;
use App\Filament\Resources\AuthorizedAccess\AuthorizedAccessUserResource\Pages\ListAuthorizedAccessUsers;
use App\Models\AuthorizedAccess\AuthorizedAccessUser;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuthorizedAccessUserResource extends Resource
{
    protected static ?string $model = AuthorizedAccessUser::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Autorizovaný přístup';
    protected static ?int $navigationSort = 10;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'AP uživatelé';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')->label('Jméno')->required(),
                TextInput::make('surname')->label('Příjmení')->required(),
                TextInput::make('company')->label('Firma'),
                TextInput::make('email')->label('E-mail')->email()->required(),
                TextInput::make('login')->label('Login')->required(),
                TextInput::make('phone')->label('Telefon'),
                TextInput::make('password')->label('Heslo')->password()->revealable(),
                Toggle::make('email_verified_at')
                    ->label('E-mail ověřen')
                    ->formatStateUsing(fn ($state) => !empty($state))
                    ->dehydrated(false),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Jméno'),
                TextColumn::make('surname')->label('Příjmení'),
                TextColumn::make('company')->label('Firma'),
                TextColumn::make('email')->label('E-mail'),
                TextColumn::make('login')->label('Login'),
                CheckboxColumn::make('email_verified_at')->label('Ověřen')->disabled(),
                TextColumn::make('last_login_at')->label('Poslední login')->dateTime('d.m.Y H:i'),
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
            'index' => ListAuthorizedAccessUsers::route('/'),
            'create' => CreateAuthorizedAccessUser::route('/create'),
            'edit' => EditAuthorizedAccessUser::route('/{record}/edit'),
        ];
    }
}