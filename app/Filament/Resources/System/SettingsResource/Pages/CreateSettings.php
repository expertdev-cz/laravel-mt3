<?php

namespace App\Filament\Resources\System\SettingsResource\Pages;

use App\Filament\Resources\System\SettingsResource;
use App\Services\System\SeoService;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\System\Settings;

class CreateSettings extends CreateRecord
{
    protected static ?string $title = 'Nastavení webu';
    protected static string $resource = SettingsResource::class;

    protected function handleRecordCreation(array $data): Settings{
        if(isset($data['content']['robots'])){
            SeoService::writeToRobotsTxt($data['content']['robots']);
        }

        $ret = static::getModel()::create($data);

        return $ret;
    }
}
