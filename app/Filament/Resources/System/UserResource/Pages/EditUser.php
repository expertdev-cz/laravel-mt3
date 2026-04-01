<?php

namespace App\Filament\Resources\System\UserResource\Pages;

use App\Filament\Resources\System\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static ?string $title = 'Editace sys. uživatele';
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
