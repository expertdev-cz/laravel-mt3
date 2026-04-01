<?php

namespace App\Filament\Resources\System;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use App\Filament\Resources\System\RedirectResource\Pages;
use App\Helpers\UrlPath;
use App\Models\System\Redirect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-arrow-right';
    protected static string|\UnitEnum|null $navigationGroup = 'Nastavení webu';
    protected static ?int $navigationSort = 16;
    protected static ?string $navigationLabel = 'Redirecty';
    protected static ?string $breadcrumb = 'Redirecty';
    protected static ?string $pluralModelLabel = 'Redirecty';
    protected static ?string $modelLabel = 'Redirect';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Nastavení redirectu')
                ->description('Definujte zdrojovou a cílovou URL adresu pro přesměrování.')
                ->schema([
                    TextInput::make('source_path')
                        ->label('Zdrojová URL')
                        ->placeholder('https://domena.cz/o-nas nebo /o-nas')
                        ->required()
                        ->regex('/^(\/|https?:\/\/).+/i')
                        ->rules([
                            function ($record) {
                                return function (string $attribute, $value, \Closure $fail) use ($record) {
                                    $normalized = UrlPath::normalize($value);
                                    
                                    $query = Redirect::where('source_path', $normalized);
                                    
                                    if ($record) {
                                        $query->where('id', '!=', $record->id);
                                    }
                                    
                                    if ($query->exists()) {
                                        $fail("Redirect se zdrojovou cestou '{$normalized}' již existuje.");
                                    }
                                };
                            },
                        ])
                        ->validationMessages([
                            'required' => 'Zdrojová URL je povinná.',
                            'regex' => 'URL musí začínat "/" nebo "http://" nebo "https://".',
                        ])
                        ->helperText('Zadejte absolutní nebo relativní URL. Při uložení se automaticky normalizuje na "/cesta" bez query parametrů.')
                        ->dehydrateStateUsing(fn ($state) => UrlPath::normalize($state))
                        ->columnSpanFull(),

                    TextInput::make('target_path')
                        ->label('Cílová URL')
                        ->placeholder('https://domena.cz/weby nebo /weby')
                        ->required()
                        ->regex('/^(\/|https?:\/\/).+/i')
                        ->validationMessages([
                            'required' => 'Cílová URL je povinná.',
                            'regex' => 'URL musí začínat "/" nebo "http://" nebo "https://".',
                        ])
                        ->helperText('URL adresa, kam se má přesměrovat. Stejně jako zdroj bude normalizována.')
                        ->dehydrateStateUsing(fn ($state) => UrlPath::normalize($state))
                        ->columnSpanFull(),

                    Select::make('status')
                        ->label('HTTP status kód')
                        ->options([
                            301 => '301 - Permanentní redirect (SEO friendly)',
                            302 => '302 - Dočasný redirect',
                            307 => '307 - Dočasný (zachová POST/GET metodu)',
                            308 => '308 - Permanentní (zachová POST/GET metodu)',
                        ])
                        ->default(301)
                        ->required()
                        ->helperText('301 = trvalá změna (doporučeno pro SEO), 302 = dočasná změna')
                        ->columnSpan(1),

                    Toggle::make('is_active')
                        ->label('Aktivní redirect')
                        ->default(true)
                        ->helperText('Vypnuté redirecty se nebudou aplikovat.')
                        ->inline(false)
                        ->columnSpan(1),
                ])
                ->columns(2),

            Section::make('Informace')
                ->schema([
                    TextEntry::make('created_at')
                        ->label('Vytvořeno')
                        ->state(fn ($record): string => $record?->created_at?->format('d.m.Y H:i') ?? '-')
                        ->hidden(fn ($record) => $record === null),

                    TextEntry::make('updated_at')
                        ->label('Poslední aktualizace')
                        ->state(fn ($record): string => $record?->updated_at?->format('d.m.Y H:i') ?? '-')
                        ->hidden(fn ($record) => $record === null),
                ])
                ->columns(2)
                ->collapsed()
                ->hiddenOn('create'),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('source_path')
                    ->label('Zdroj')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Zdrojová cesta zkopírována')
                    ->icon('heroicon-m-arrow-right-circle')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->source_path),

                TextColumn::make('target_path')
                    ->label('Cíl')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Cílová cesta zkopírována')
                    ->icon('heroicon-m-arrow-up-right')
                    ->limit(40)
                    ->tooltip(fn ($record) => $record->target_path),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (int $state): string => match($state) {
                        301, 308 => 'success',
                        302, 307 => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (int $state): string => match($state) {
                        301 => '301 Permanent',
                        302 => '302 Temporary',
                        307 => '307 Temporary',
                        308 => '308 Permanent',
                        default => (string) $state,
                    })
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktivní')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Aktualizováno')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->since()
                    ->tooltip(fn ($record) => $record->updated_at->format('d.m.Y H:i:s'))
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('created_at')
                    ->label('Vytvořeno')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status redirectu')
                    ->placeholder('Všechny redirecty')
                    ->trueLabel('Pouze aktivní')
                    ->falseLabel('Pouze neaktivní')
                    ->native(false),

                SelectFilter::make('status')
                    ->label('HTTP status kód')
                    ->options([
                        301 => '301 - Permanentní',
                        302 => '302 - Dočasný',
                        307 => '307 - Dočasný (zachová metodu)',
                        308 => '308 - Permanentní (zachová metodu)',
                    ])
                    ->native(false),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label('Detail'),
                    EditAction::make()
                        ->label('Upravit'),
                    Action::make('toggle_active')
                        ->label(fn ($record) => $record->is_active ? 'Deaktivovat' : 'Aktivovat')
                        ->icon(fn ($record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                        ->color(fn ($record) => $record->is_active ? 'danger' : 'success')
                        ->action(function (Redirect $record) {
                            $record->is_active = !$record->is_active;
                            $record->save();
                        })
                        ->requiresConfirmation(false)
                        ->successNotificationTitle(fn ($record) => $record->is_active ? 'Redirect aktivován' : 'Redirect deaktivován'),
                    DeleteAction::make()
                        ->label('Smazat'),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Smazat vybrané'),
                    BulkAction::make('activate')
                        ->label('Aktivovat vybrané')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each->update(['is_active' => true]);
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->modalHeading('Aktivovat vybrané redirecty?')
                        ->modalDescription('Všechny vybrané redirecty budou aktivovány.')
                        ->successNotificationTitle('Redirecty byly aktivovány'),
                    BulkAction::make('deactivate')
                        ->label('Deaktivovat vybrané')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each->update(['is_active' => false]);
                        })
                        ->deselectRecordsAfterCompletion()
                        ->requiresConfirmation()
                        ->modalHeading('Deaktivovat vybrané redirecty?')
                        ->modalDescription('Všechny vybrané redirecty budou deaktivovány.')
                        ->successNotificationTitle('Redirecty byly deaktivovány'),
                ]),
            ])
            ->defaultSort('updated_at', 'desc')
            ->striped()
            ->emptyStateHeading('Žádné redirecty')
            ->emptyStateDescription('Zatím nebyly vytvořeny žádné redirecty. Vytvořte první redirect pomocí tlačítka níže.')
            ->emptyStateIcon('heroicon-o-arrow-right')
            ->emptyStateActions([
                CreateAction::make()
                    ->label('Vytvořit první redirect')
                    ->icon('heroicon-o-plus'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListRedirects::route('/'),
            'create' => Pages\CreateRedirect::route('/create'),
            'edit'   => Pages\EditRedirect::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('is_active', true)->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        $count = static::getModel()::where('is_active', true)->count();
        return $count === 1 ? '1 aktivní redirect' : "{$count} aktivních redirectů";
    }
}