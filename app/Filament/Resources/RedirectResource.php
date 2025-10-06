<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RedirectResource\Pages;
use App\Models\Redirect;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-uturn-right';
    protected static string | \UnitEnum | null $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 70;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\TextInput::make('from')
                ->required()
                ->helperText('Old path, e.g., /old/path/'),
            Forms\Components\TextInput::make('to')
                ->required()
                ->helperText('New absolute or relative path'),
            Forms\Components\TextInput::make('http_status')
                ->numeric()
                ->default(301),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('from')->searchable()->limit(60),
            Tables\Columns\TextColumn::make('to')->limit(60),
            Tables\Columns\TextColumn::make('http_status'),
        ])->recordActions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRedirects::route('/'),
            'create' => Pages\CreateRedirect::route('/create'),
            'edit' => Pages\EditRedirect::route('/{record}/edit'),
        ];
    }
}
