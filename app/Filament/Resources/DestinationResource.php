<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DestinationResource\Pages;
use App\Models\{Destination, Country};
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

class DestinationResource extends Resource
{
    protected static ?string $model = Destination::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-map';
    protected static string | UnitEnum | null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 15;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Components\Tabs::make('Tabs')
                    ->tabs([
                        Components\Tabs\Tab::make('Main')->schema([
                            Components\Grid::make(12)->schema([
                                Forms\Components\Select::make('country_id')
                                    ->label('Country')
                                    ->relationship('country', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')->required(),
                                        Forms\Components\TextInput::make('slug')->required(),
                                        Forms\Components\TextInput::make('iso2')->maxLength(2),
                                    ])
                                    ->columnSpan(4),

                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set, $get) {
                                        if (blank($get('slug'))) {
                                            $set('slug', Str::slug($state));
                                        }
                                    })
                                    ->columnSpan(8),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->columnSpan(6)
                                    ->helperText('Auto-generated from name'),

                                Forms\Components\TextInput::make('video_url')
                                    ->url()
                                    ->maxLength(255)
                                    ->placeholder('https://youtube.com/...')
                                    ->columnSpan(6)
                                    ->helperText('Optional video URL for hero section'),

                                Forms\Components\Textarea::make('excerpt')
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->columnSpan(12)
                                    ->helperText('Short description shown in listings and under heading'),

                                \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('banner')
                                    ->label('Banner Image')
                                    ->collection('banner')
                                    ->disk('public')
                                    ->image()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios(['16:9'])
                                    ->maxFiles(1)
                                    ->columnSpan(6)
                                    ->helperText('Main banner/hero image'),

                                \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('gallery')
                                    ->label('Gallery Images')
                                    ->collection('gallery')
                                    ->disk('public')
                                    ->multiple()
                                    ->reorderable()
                                    ->image()
                                    ->imageEditor()
                                    ->maxFiles(10)
                                    ->columnSpan(6)
                                    ->helperText('Additional images for content sections'),

                                Forms\Components\RichEditor::make('description_html')
                                    ->label('Main Description')
                                    ->columnSpan(12)
                                    ->toolbarButtons([
                                        'bold','italic','strike','underline','h2','h3','blockquote',
                                        'orderedList','bulletList','link','undo','redo',
                                    ])
                                    ->helperText('Rich content for "History/Discover" section'),
                            ]),
                        ]),

                        Components\Tabs\Tab::make('Facts & Info')->schema([
                            Components\Grid::make(12)->schema([
                                Components\Section::make('Quick Facts')
                                    ->description('Four key facts displayed on the banner')
                                    ->schema([
                                        Forms\Components\TextInput::make('facts.language')
                                            ->label('Language')
                                            ->placeholder('English')
                                            ->columnSpan(6),
                                        Forms\Components\TextInput::make('facts.currency')
                                            ->label('Currency')
                                            ->placeholder('USD')
                                            ->columnSpan(6),
                                        Forms\Components\TextInput::make('facts.religion')
                                            ->label('Religion')
                                            ->placeholder('Christianity')
                                            ->columnSpan(6),
                                        Forms\Components\TextInput::make('facts.timezone')
                                            ->label('Timezone')
                                            ->placeholder('UTC+0')
                                            ->columnSpan(6),
                                    ])
                                    ->columns(12)
                                    ->columnSpan(12),

                                Forms\Components\RichEditor::make('best_time_html')
                                    ->label('Best Time to Visit')
                                    ->columnSpan(12)
                                    ->toolbarButtons(['bold','italic','orderedList','bulletList'])
                                    ->helperText('When is the best time to visit this destination'),

                                Components\Section::make('Weather Information (Optional)')
                                    ->description('Optional weather details in JSON format')
                                    ->schema([
                                        Forms\Components\TextInput::make('weather_json.average_temp')
                                            ->label('Average Temperature')
                                            ->placeholder('25°C - 30°C'),
                                        Forms\Components\TextInput::make('weather_json.rainy_season')
                                            ->label('Rainy Season')
                                            ->placeholder('November to March'),
                                        Forms\Components\TextInput::make('weather_json.dry_season')
                                            ->label('Dry Season')
                                            ->placeholder('April to October'),
                                    ])
                                    ->columns(3)
                                    ->columnSpan(12)
                                    ->collapsible(),

                                Components\Section::make('Travel Tips')
                                    ->schema([
                                        Forms\Components\RichEditor::make('travel_tips_html')
                                            ->label('')
                                            ->toolbarButtons(['bold','italic','orderedList','bulletList'])
                                            ->helperText('Useful tips for travelers'),
                                    ])
                                    ->columnSpan(12)
                                    ->collapsible(),
                            ]),
                        ]),

                        Components\Tabs\Tab::make('Seasonal Activities')->schema([
                            Forms\Components\Repeater::make('activities')
                                ->relationship('activities')
                                ->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->required()
                                        ->placeholder('Summer (February - May)')
                                        ->columnSpan(12),
                                    Forms\Components\RichEditor::make('brief_html')
                                        ->label('Description')
                                        ->required()
                                        ->toolbarButtons(['bold','italic','orderedList','bulletList'])
                                        ->columnSpan(12),
                                    Forms\Components\Hidden::make('sort_order'),
                                ])
                                ->orderColumn('sort_order')
                                ->reorderable()
                                ->collapsible()
                                ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                ->addActionLabel('Add Activity')
                                ->defaultItems(0)
                                ->helperText('Activities displayed in an accordion on the destination page'),
                        ]),

                        Components\Tabs\Tab::make('Must-Know Items')->schema([
                            Forms\Components\Repeater::make('items')
                                ->relationship('items')
                                ->schema([
                                    Forms\Components\TextInput::make('title')
                                        ->required()
                                        ->placeholder('Visa Requirements')
                                        ->columnSpan(12),
                                    Forms\Components\RichEditor::make('body_html')
                                        ->label('Content')
                                        ->required()
                                        ->toolbarButtons(['bold','italic','orderedList','bulletList','link'])
                                        ->columnSpan(12),
                                    \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                                        ->collection('image')
                                        ->disk('public')
                                        ->image()
                                        ->imageEditor()
                                        ->maxFiles(1)
                                        ->columnSpan(6)
                                        ->helperText('Image for this item'),
                                    Forms\Components\TextInput::make('url')
                                        ->label('More Info URL (Optional)')
                                        ->url()
                                        ->placeholder('https://...')
                                        ->columnSpan(6),
                                    Forms\Components\Hidden::make('sort_order'),
                                ])
                                ->orderColumn('sort_order')
                                ->reorderable()
                                ->collapsible()
                                ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                ->addActionLabel('Add Must-Know Item')
                                ->defaultItems(0)
                                ->helperText('Items displayed in a slider/carousel'),
                        ]),

                        Components\Tabs\Tab::make('Settings')->schema([
                            Components\Grid::make(12)->schema([
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured Destination')
                                    ->helperText('Show in "Top Destinations" carousel')
                                    ->columnSpan(6),

                                Forms\Components\TextInput::make('order')
                                    ->label('Display Order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Lower numbers appear first (for featured destinations)')
                                    ->columnSpan(6),

                                Forms\Components\Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                    ])
                                    ->default('draft')
                                    ->required()
                                    ->columnSpan(6),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Publish Date')
                                    ->columnSpan(6),
                            ]),
                        ]),

                        Components\Tabs\Tab::make('SEO')->schema([
                            Components\Grid::make(12)->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->maxLength(255)
                                    ->placeholder('Override default title')
                                    ->columnSpan(12)
                                    ->helperText('Leave blank to use: "{Name} — {Site Name}"'),

                                Forms\Components\Textarea::make('meta_description')
                                    ->rows(3)
                                    ->maxLength(160)
                                    ->placeholder('Brief description for search engines')
                                    ->columnSpan(12)
                                    ->helperText('Max 160 characters for optimal display'),

                                Forms\Components\TextInput::make('canonical_url')
                                    ->url()
                                    ->placeholder('https://...')
                                    ->columnSpan(12)
                                    ->helperText('Leave blank to use current URL'),

                                Forms\Components\Toggle::make('noindex')
                                    ->label('No Index')
                                    ->helperText('Prevent search engines from indexing this page')
                                    ->columnSpan(6),
                            ]),
                        ]),
                    ])
                    ->columnSpan(12),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('banner')
                    ->collection('banner')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('country.name')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                Tables\Columns\TextColumn::make('tours_count')
                    ->counts('tours')
                    ->label('Tours')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('country')
                    ->relationship('country', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ]),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDestinations::route('/'),
            'create' => Pages\CreateDestination::route('/create'),
            'edit' => Pages\EditDestination::route('/{record}/edit'),
        ];
    }
}
