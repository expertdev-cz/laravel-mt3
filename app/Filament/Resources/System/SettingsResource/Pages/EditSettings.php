<?php

namespace App\Filament\Resources\System\SettingsResource\Pages;

use App\Filament\Resources\System\SettingsResource;
use App\Services\System\SeoService;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditSettings extends EditRecord
{
    protected static ?string $title = 'Nastavení webu';
    protected static string $resource = SettingsResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model{
        if(isset($data['content']['robots'])){
            SeoService::writeToRobotsTxt($data['content']['robots']);
        }

        $record->update($data);
        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            //DeleteAction::make(),
        ];
    }
}
