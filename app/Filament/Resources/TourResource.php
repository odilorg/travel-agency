<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Models\{Tour, City, Category, Tag};
use BackedEnum;
use UnitEnum;
use Filament\Actions;
use Filament\Forms;
use Filament\Schemas\Components;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-map';
    protected static string | UnitEnum | null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 10;
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Components\Tabs::make('Tabs')
                    ->tabs([
                        Components\Tabs\Tab::make('Main')->schema([
                            Components\Grid::make(12)->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->columnSpan(8)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                        if (blank($get('slug'))) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(80)
                                    ->columnSpan(4),
                                Forms\Components\Textarea::make('excerpt')
                                    ->rows(3)
                                    ->maxLength(350)
                                    ->columnSpan(12),
                                Forms\Components\RichEditor::make('description_html')
                                    ->columnSpan(12)
                                    ->toolbarButtons([
                                        'bold','italic','strike','underline','h2','h3','blockquote',
                                        'orderedList','bulletList','link','undo','redo',
                                    ]),
                            ]),
                        ]),

                        Components\Tabs\Tab::make('Details')->schema([
                            Components\Grid::make(12)->schema([
                                Forms\Components\TextInput::make('duration_days')->numeric()->minValue(0)->columnSpan(2),
                                Forms\Components\TextInput::make('duration_nights')->numeric()->minValue(0)->columnSpan(2),
                                Forms\Components\TextInput::make('price_from')->numeric()->prefix('$')->columnSpan(3),
                                Forms\Components\TextInput::make('currency')->default('USD')->maxLength(3)->columnSpan(2),
                                Forms\Components\Select::make('city_id')
                                    ->label('City')
                                    ->options(City::query()->pluck('name','id'))
                                    ->searchable()
                                    ->preload()
                                    ->columnSpan(3),
                                Forms\Components\Select::make('difficulty')
                                    ->options(['easy'=>'Easy','moderate'=>'Moderate','hard'=>'Hard'])
                                    ->columnSpan(3),
                                Forms\Components\Toggle::make('is_featured')->columnSpan(2),
                                Forms\Components\TextInput::make('latitude')->numeric()->columnSpan(2),
                                Forms\Components\TextInput::make('longitude')->numeric()->columnSpan(2),
                                Forms\Components\Select::make('categories')
                                    ->relationship('categories','name')
                                    ->multiple()->preload()->searchable()
                                    ->columnSpan(6),
                                Forms\Components\Select::make('tags')
                                    ->relationship('tags','name')
                                    ->multiple()->preload()->searchable()
                                    ->columnSpan(6),
                            ]),
                        ]),

                        Components\Tabs\Tab::make('Pricing')->schema([
                            Components\Repeater::make('priceOptions')
                                ->relationship()
                                ->schema([
                                    Forms\Components\TextInput::make('name')->required(),
                                    Forms\Components\TextInput::make('price')->numeric()->required(),
                                    Forms\Components\TextInput::make('currency')->maxLength(3)->default('USD'),
                                    Forms\Components\TextInput::make('min_pax')->numeric()->minValue(1),
                                    Forms\Components\TextInput::make('max_pax')->numeric()->minValue(1),
                                    Forms\Components\Toggle::make('is_active')->default(true),
                                ])->orderable('position')->collapsible()->grid(2),
                            Components\Repeater::make('extras')
                                ->relationship()
                                ->schema([
                                    Forms\Components\TextInput::make('label')->required(),
                                    Forms\Components\Textarea::make('description')->rows(2),
                                    Forms\Components\TextInput::make('price')->numeric(),
                                    Forms\Components\Toggle::make('per_person')->default(false),
                                ])->orderable('position')->collapsible()->grid(2),
                        ]),

                        Components\Tabs\Tab::make('Highlights')->schema([
                            Components\Repeater::make('highlights')
                                ->relationship()->schema([
                                    Forms\Components\TextInput::make('label')->required(),
                                ])->orderable('position')->columns(1),
                            Components\Repeater::make('inclusions')
                                ->relationship()->schema([
                                    Forms\Components\TextInput::make('label')->required(),
                                ])->orderable('position')->columns(1),
                            Components\Repeater::make('exclusions')
                                ->relationship()->schema([
                                    Forms\Components\TextInput::make('label')->required(),
                                ])->orderable('position')->columns(1),
                        ]),

                        Components\Tabs\Tab::make('Itinerary')->schema([
                            Components\Repeater::make('itineraryItems')
                                ->relationship()
                                ->schema([
                                    Forms\Components\TextInput::make('day')->numeric()->minValue(0),
                                    Forms\Components\TextInput::make('time'),
                                    Forms\Components\TextInput::make('title'),
                                    Forms\Components\RichEditor::make('body_html')->toolbarButtons([
                                        'bold','italic','strike','underline','h3','blockquote',
                                        'orderedList','bulletList','link','undo','redo',
                                    ]),
                                ])->orderable('position')->collapsible()->grid(1),
                        ]),

                        Components\Tabs\Tab::make('FAQs')->schema([
                            Components\Repeater::make('faqs')
                                ->relationship()
                                ->schema([
                                    Forms\Components\TextInput::make('question')->required(),
                                    Forms\Components\RichEditor::make('answer_html')->toolbarButtons([
                                        'bold','italic','orderedList','bulletList','link',
                                    ]),
                                ])->orderable('position')->collapsible()->grid(1),
                        ]),

                        Components\Tabs\Tab::make('SEO')->schema([
                            Forms\Components\TextInput::make('meta_title')->maxLength(70)
                                ->helperText('Max ~60–70 chars'),
                            Forms\Components\TextInput::make('meta_description')->maxLength(180)
                                ->helperText('Max ~150–180 chars'),
                            Forms\Components\TextInput::make('canonical_url')->url(),
                            Forms\Components\Toggle::make('noindex')->inline(false),
                            Forms\Components\Toggle::make('notranslate')->inline(false),
                        ]),

                        Components\Tabs\Tab::make('Publishing')->schema([
                            Forms\Components\Select::make('status')
                                ->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived'])
                                ->required(),
                            Forms\Components\DateTimePicker::make('published_at'),
                        ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(40),
                Tables\Columns\TextColumn::make('city.name')->label('City')->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'warning',
                        'published' => 'success',
                        'archived' => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_from')->money('usd', true)->label('From'),
                Tables\Columns\TextColumn::make('published_at')->dateTime()->since()->sortable(),
                Tables\Columns\ToggleColumn::make('is_featured')->label('Featured'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('city_id')->label('City')
                    ->options(City::query()->pluck('name','id'))->searchable(),
                Tables\Filters\SelectFilter::make('status')
                    ->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived']),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Featured'),
            ])
            ->actions([
                Actions\ViewAction::make(),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }
}
