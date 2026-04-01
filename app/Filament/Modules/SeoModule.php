<?php

namespace App\Filament\Modules;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class SeoModule
{
    public static function getDefinition(string $arrayToSaveName = 'seo'): Fieldset
    {
        return Fieldset::make('Seo')
            ->schema([
                Tabs::make('seoTabs')
                    ->tabs([

                        // --- ZÁKLADNÍ ---
                        Tab::make('Základní')
                            ->schema([
                                TextInput::make($arrayToSaveName . '.title')
                                    ->label('Meta title')
                                    ->placeholder('Titulek stránky (50–60 znaků)')
                                    ->maxLength(70)
                                    ->columnSpan(2),

                                Textarea::make($arrayToSaveName . '.desc')
                                    ->label('Meta description')
                                    ->placeholder('Stručný popis stránky (80–160 znaků)')
                                    ->maxLength(180)
                                    ->columnSpan(2),

                                TextInput::make($arrayToSaveName . '.keywords')
                                    ->label('Keywords (nepovinné)')
                                    ->helperText('Pro interní použití, nehraje roli v SEO.'),

                                TextInput::make($arrayToSaveName . '.canonical_URL')
                                    ->label('Kanonická URL')
                                    ->placeholder('https://www.example.cz/stranka/')
                                    ->url()
                                    ->columnSpan(2)
                                    // Při načtení formuláře (hlavně create) chytře předvyplň ze slugu.
                                    ->afterStateHydrated(function (Get $get, Set $set, $state, $record) use ($arrayToSaveName) {
                                        if (filled($state)) {
                                            return;
                                        }

                                        // Slug článku
                                        $slug = trim((string) $get('slug'), '/');
                                        if ($slug === '') {
                                            return;
                                        }

                                        $base = rtrim((string) config('app.url'), '/');

                                        /**
                                        * 1) ZÍSKÁME SLUG BLOGOVÉ STRÁNKY
                                        *    (např. v Pages tabulce máš záznam s typem 'blog' nebo 'blog_home')
                                        */
                                        $blogPage = \App\Models\System\Page::where('type', 'blog')->first();
                                        $blogSlug = $blogPage ? trim($blogPage->slug, '/') : 'blog'; // fallback

                                        /**
                                        * 2) ZJISTÍME, jestli jde o článek
                                        */
                                        $isArticle = $record instanceof \App\Models\Content\Article;

                                        /**
                                        * 3) Sestavíme canonical
                                        */
                                        $prefix = $isArticle ? '/' . $blogSlug : '';
                                        $canonical = $base . $prefix . '/' . $slug;

                                        $set($arrayToSaveName . '.canonical_URL', $canonical);
                                    })

                                    ->helperText('Automaticky se doplní ze slugu při vytváření, ale lze libovolně přepsat.'),

                                Select::make($arrayToSaveName . '.robots')
                                    ->label('Robots Meta Tag')
                                    ->options([
                                        'index, follow' => 'Index, Follow - Indexuj stránku i odkazy (výchozí)',
                                        'index, nofollow' => 'Index, NoFollow - Indexuj stránku, ale nesleduj odkazy',
                                        'noindex, follow' => 'NoIndex, Follow - Neindexuj stránku, ale sleduj odkazy',
                                        'noindex, nofollow' => 'NoIndex, NoFollow - Neindexuj stránku ani odkazy',
                                    ])
                                    ->default('index, follow')
                                    ->afterStateHydrated(function (Set $set, $state) use ($arrayToSaveName) {
                                        if (blank($state)) {
                                            $set($arrayToSaveName . '.robots', 'index, follow');
                                        }
                                    })
                                    ->dehydrated()
                                    ->helperText('Nastavení pro vyhledávače - jak mají indexovat stránku')
                                    ->native(false),
                            ])
                            ->columns(3),

                        // --- OPEN GRAPH ---
                        Tab::make('Open Graph')
                            ->schema([
                                TextInput::make($arrayToSaveName . '.og_title')
                                    ->label('og:title')
                                    ->placeholder('Titulek pro sdílení na sociálních sítích'),

                                Textarea::make($arrayToSaveName . '.og_desc')
                                    ->label('og:description')
                                    ->placeholder('Krátký popis pro sdílení (max 200 znaků)')
                                    ->maxLength(200),

                                Select::make($arrayToSaveName . '.og_type')
                                    ->label('og:type')
                                    ->options([
                                        'website' => 'website',
                                        'article' => 'article',
                                        'product' => 'product',
                                    ])
                                    ->default('website')
                                    ->afterStateHydrated(function (Set $set, $state) use ($arrayToSaveName) {
                                        if (blank($state)) {
                                            $set($arrayToSaveName . '.og_type', 'website');
                                        }
                                    })
                                    ->dehydrated()
                                    ->helperText('Typ obsahu pro sdílení – většinou "website", u článků "article", u produktů "product".'),

                                FileUpload::make($arrayToSaveName . '.og_image')
                                    ->label('og:image')
                                    ->image()
                                    ->directory('og-images')
                                    ->preserveFilenames()
                                    ->deleteUploadedFileUsing(function ($file) {
                                        if ($file) {
                                            Storage::disk('public')->delete($file);
                                        }
                                    })
                                    ->helperText('Doporučeno 1200×630 px (poměr 1.91:1).'),
                            ])
                            ->columns(2),

                        // --- TWITTER ---
                        Tab::make('Twitter')
                            ->schema([
                                TextInput::make($arrayToSaveName . '.twitter_title')
                                    ->label('twitter:title')
                                    ->placeholder('Titulek pro Twitter')
                                    ->maxLength(95),

                                Textarea::make($arrayToSaveName . '.twitter_desc')
                                    ->label('twitter:description')
                                    ->placeholder('Popis pro Twitter (max 200 znaků)')
                                    ->maxLength(200),

                                FileUpload::make($arrayToSaveName . '.twitter_image')
                                    ->label('twitter:image')
                                    ->image()
                                    ->directory('og-images')
                                    ->preserveFilenames()
                                    ->deleteUploadedFileUsing(function ($file) {
                                        if ($file) {
                                            Storage::disk('public')->delete($file);
                                        }
                                    })
                                    ->helperText('Doporučeno 1200×630 px (poměr 1.91:1).'),
                            ])
                            ->columns(2),

                        // --- HREFLANG ---
                        Tab::make('Hreflang')
                            ->schema([
                                Repeater::make($arrayToSaveName . '.hreflang')
                                    ->label('Alternativní jazykové verze')
                                    ->schema([
                                        TextInput::make('locale')
                                            ->label('Jazyk/region (např. cs-CZ)')
                                            ->required(),
                                        TextInput::make('url')
                                            ->label('URL')
                                            ->url()
                                            ->required(),
                                    ])
                                    ->collapsed()
                                    ->default([])
                                    ->addActionLabel('Přidat jazykovou verzi')
                                    ->columns(2)
                                    ->helperText('Použij pouze u vícejazyčných stránek.'),
                            ]),
                    ])
                    ->persistTabInQueryString()
            ])
            ->columns(1);
    }
}
