<?php

namespace App\Filament\Modules;

use App\Models\System\Page;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;

class MenuModule
{
    public static function getDefinition(bool $addInFooterOpt=false, bool $addForLoggedOpt=false): Fieldset{
        $optArr = [];

        if ($addInFooterOpt){
            $optArr[] = Checkbox::make('in_footer_menu')->default(0)->label('Zobrazit ve footeru');
        }

        if ($addForLoggedOpt){
            $optArr[] = Checkbox::make('in_menu_only_for_logged')->default(0)->label('Zobrazit ve footeru (Zákaznická zóna)');
        }

        return Fieldset::make('Nastavení menu')
            ->schema(array_merge([
                Checkbox::make('in_menu')->default(0)->label('Zobrazit v hl. menu')
            ],$optArr,[
                TextInput::make('in_menu_title')->default('')->label('Název v menu'),
                TextInput::make('in_menu_order')->default(0)->numeric()->label('Pořadí v menu'),
                Select::make('parent_id')->options(Page::whereActive(1)->get(['id','title'])->pluck('title','id'))->label('Nadřazená stránka'),
            ]))->columns(3);
    }
}
