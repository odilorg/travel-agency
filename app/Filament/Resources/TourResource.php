<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Models\{Tour, City, Category, Tag};
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select as FormSelect;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Support\Str;

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-map';
    protected static string | \UnitEnum | null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 10;
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Main')->schema([
                            Grid::make(12)->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->columnSpan(8)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                        if (blank($get('slug'))) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),
                                TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(80)
                                    ->columnSpan(4),
                                Textarea::make('excerpt')
                                    ->rows(3)
                                    ->maxLength(350)
                                    ->columnSpan(12),
                                RichEditor::make('description_html')
                                    ->columnSpan(12)
                                    ->toolbarButtons([
                                        'bold','italic','strike','underline','h2','h3','blockquote',
                                        'orderedList','bulletList','link','undo','redo',
                                    ]),
                            ]),
                        ]),

                        Tab::make('Details')->schema([
                            Grid::make(12)->schema([
                                TextInput::make('duration_days')->numeric()->minValue(0)->columnSpan(2),
                                TextInput::make('duration_nights')->numeric()->minValue(0)->columnSpan(2),
                                TextInput::make('price_from')->numeric()->prefix('$')->columnSpan(3),
                                TextInput::make('currency')->default('USD')->maxLength(3)->columnSpan(2),
                                FormSelect::make('city_id')
                                    ->label('City')
                                    ->options(City::query()->pluck('name','id'))
                                    ->searchable()
                                    ->preload()
                                    ->columnSpan(3),
                                FormSelect::make('difficulty')
                                    ->options(['easy'=>'Easy','moderate'=>'Moderate','hard'=>'Hard'])
                                    ->columnSpan(3),
                                Toggle::make('is_featured')->columnSpan(2),
                                TextInput::make('latitude')->numeric()->columnSpan(2),
                                TextInput::make('longitude')->numeric()->columnSpan(2),
                                FormSelect::make('categories')
                                    ->relationship('categories','name')
                                    ->multiple()->preload()->searchable()
                                    ->columnSpan(6),
                                FormSelect::make('tags')
                                    ->relationship('tags','name')
                                    ->multiple()->preload()->searchable()
                                    ->columnSpan(6),
                            ]),
                        ]),

                        Tab::make('Pricing')->schema([
                            Repeater::make('priceOptions')
                                ->relationship()
                                ->schema([
                                    TextInput::make('name')->required(),
                                    TextInput::make('price')->numeric()->required(),
                                    TextInput::make('currency')->maxLength(3)->default('USD'),
                                    TextInput::make('min_pax')->numeric()->minValue(1),
                                    TextInput::make('max_pax')->numeric()->minValue(1),
                                    Toggle::make('is_active')->default(true),
                                ])->orderable('position')->collapsible()->grid(2),
                            Repeater::make('extras')
                                ->relationship()
                                ->schema([
                                    TextInput::make('label')->required(),
                                    Textarea::make('description')->rows(2),
                                    TextInput::make('price')->numeric(),
                                    Toggle::make('per_person')->default(false),
                                ])->orderable('position')->collapsible()->grid(2),
                        ]),

                        Tab::make('Highlights')->schema([
                            Repeater::make('highlights')
                                ->relationship()->schema([
                                    TextInput::make('label')->required(),
                                ])->orderable('position')->columns(1),
                            Repeater::make('inclusions')
                                ->relationship()->schema([
                                    TextInput::make('label')->required(),
                                ])->orderable('position')->columns(1),
                            Repeater::make('exclusions')
                                ->relationship()->schema([
                                    TextInput::make('label')->required(),
                                ])->orderable('position')->columns(1),
                        ]),

                        Tab::make('Itinerary')->schema([
                            Repeater::make('itineraryItems')
                                ->relationship()
                                ->schema([
                                    TextInput::make('day')->numeric()->minValue(0),
                                    TextInput::make('time'),
                                    TextInput::make('title'),
                                    RichEditor::make('body_html')->toolbarButtons([
                                        'bold','italic','strike','underline','h3','blockquote',
                                        'orderedList','bulletList','link','undo','redo',
                                    ]),
                                ])->orderable('position')->collapsible()->grid(1),
                        ]),

                        Tab::make('FAQs')->schema([
                            Repeater::make('faqs')
                                ->relationship()
                                ->schema([
                                    TextInput::make('question')->required(),
                                    RichEditor::make('answer_html')->toolbarButtons([
                                        'bold','italic','orderedList','bulletList','link',
                                    ]),
                                ])->orderable('position')->collapsible()->grid(1),
                        ]),

                        Tab::make('SEO')->schema([
                            TextInput::make('meta_title')->maxLength(70)
                                ->helperText('Max ~60–70 chars'),
                            TextInput::make('meta_description')->maxLength(180)
                                ->helperText('Max ~150–180 chars'),
                            TextInput::make('canonical_url')->url(),
                            Toggle::make('noindex')->inline(false),
                            Toggle::make('notranslate')->inline(false),
                        ]),

                        Tab::make('Publishing')->schema([
                            FormSelect::make('status')
                                ->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived'])
                                ->required(),
                            DateTimePicker::make('published_at'),
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
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
