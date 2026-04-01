<?php

namespace App\Filament\Resources\Content\TagsResource\Pages;

use App\Filament\Resources\Content\TagsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTags extends CreateRecord
{
    protected static string $resource = TagsResource::class;
}
