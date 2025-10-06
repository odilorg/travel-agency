<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourReviewResource\Pages;
use App\Models\TourReview;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class TourReviewResource extends Resource
{
    protected static ?string $model = TourReview::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-star';
    protected static string | \UnitEnum | null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Forms\Components\Select::make('tour_id')
                ->relationship('tour','title')
                ->searchable()
                ->preload()
                ->required(),
            Forms\Components\TextInput::make('author_name')->required(),
            Forms\Components\TextInput::make('author_email')->email()->required(),
            Forms\Components\TextInput::make('rating')
                ->numeric()
                ->minValue(1)
                ->maxValue(5)
                ->required(),
            Forms\Components\TextInput::make('title'),
            Forms\Components\Textarea::make('body')->rows(4),
            Forms\Components\Toggle::make('verified_booking'),
            Forms\Components\Toggle::make('approved'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('tour.title')->limit(40)->label('Tour'),
            Tables\Columns\TextColumn::make('author_name'),
            Tables\Columns\TextColumn::make('rating')
                ->badge()
                ->color(fn (int $state): string => $state >= 4 ? 'success' : ($state == 3 ? 'warning' : 'danger')),
            Tables\Columns\IconColumn::make('verified_booking')->boolean(),
            Tables\Columns\IconColumn::make('approved')->boolean(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->since(),
        ])->filters([
            Tables\Filters\TernaryFilter::make('approved'),
            Tables\Filters\TernaryFilter::make('verified_booking'),
        ])->recordActions([
            EditAction::make(),
            DeleteAction::make(),
        ])->bulkActions([
            BulkActionGroup::make([
                DeleteBulkAction::make()
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTourReviews::route('/'),
            'create' => Pages\CreateTourReview::route('/create'),
            'edit' => Pages\EditTourReview::route('/{record}/edit'),
        ];
    }
}
