<?php

namespace App\Livewire\System;

use App\Models\System\Language;
use App\Services\System\UrlService;
use Livewire\Component;

class LanguageSelect extends Component
{
    public string $variant = 'header';

    public function changeLang(string $selectLocale, string $actualUrl){
        session(['setLang' => $selectLocale]);
        $this->redirect(UrlService::getSamePageInDiffLangRedirUrl($actualUrl, $selectLocale));
    }

    public function render(){
        $data = Language::whereActive(1)->get();
        $actual = $data->where('locale', '=', app()->getLocale())->first();

        return view('livewire.system.language-select',[
            'langs'   => $data,
            'actual'  => $actual,
            'variant' => $this->variant,
        ]);
    }
}
