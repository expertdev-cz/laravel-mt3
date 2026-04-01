<?php

namespace App\Filament\Resources\Content\ArticleResource\Pages;

use App\Filament\Resources\Content\ArticleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListArticles extends ListRecords
{
    protected static ?string $title = 'Přehled článků';
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
