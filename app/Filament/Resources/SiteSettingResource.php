<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use BackedEnum;
use UnitEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string | UnitEnum | null $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 80;
    protected static ?string $recordTitleAttribute = 'site_name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Section::make('Brand')->schema([
                Forms\Components\TextInput::make('site_name'),
                Forms\Components\TextInput::make('default_locale')->default('en'),
            ])->columns(2),
            Forms\Components\Section::make('Contact & Social')->schema([
                Forms\Components\TextInput::make('contact_email')->email(),
                Forms\Components\KeyValue::make('social_links')
                    ->keyLabel('Network')
                    ->valueLabel('URL')
                    ->addButtonLabel('Add Link'),
            ]),
            Forms\Components\Section::make('SEO Defaults & Security')->schema([
                Forms\Components\KeyValue::make('default_meta')
                    ->keyLabel('Key')
                    ->valueLabel('Value')
                    ->addButtonLabel('Add Meta'),
                Forms\Components\TextInput::make('recaptcha_site_key'),
                Forms\Components\TextInput::make('recaptcha_secret_key'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('site_name'),
            Tables\Columns\TextColumn::make('default_locale'),
            Tables\Columns\TextColumn::make('contact_email'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSiteSettings::route('/'),
        ];
    }
}
