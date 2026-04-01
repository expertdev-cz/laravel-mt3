<?php

namespace App\Filament\Resources\System;

use Filament\Actions\EditAction;
use App\Filament\Resources\System\UserResource\Pages;
use App\Filament\Resources\System\UserResource\RelationManagers;
use App\Models\System\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Nastavení webu';
    protected static ?int $navigationSort = 40;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Sys. uživatelé';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->required(),
                TextInput::make('password')->required()->password(),
                Select::make('role_name')->required()->options(['root'=>'root','admin'=>'admin','editor'=>'editor','servis'=>'servis','lang'=>'Jazyk. mutace']),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Jméno'),
                TextColumn::make('email')->label('email'),
                TextColumn::make('role_name')->label('role'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])->bulkActions([ ]);
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
