<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\{Post, Category, Tag, User};
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

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-text';
    protected static string | UnitEnum | null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Tabs::make('Tabs')->tabs([
                Components\Tabs\Tab::make('Main')->schema([
                    Components\Grid::make(12)->schema([
                        Forms\Components\TextInput::make('title')->required()->columnSpan(8)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Always auto-generate slug from title for consistency
                                $set('slug', Str::slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(80)
                            ->columnSpan(4)
                            ->helperText('Auto-generated from title. You can edit if needed.'),
                        Forms\Components\Textarea::make('excerpt')->rows(3)->maxLength(350)->columnSpan(12),
                        Forms\Components\RichEditor::make('body_html')
                            ->toolbarButtons([
                                'bold','italic','strike','underline',
                                'h2','h3',
                                'blockquote','codeBlock','horizontalRule',
                                'orderedList','bulletList',
                                'link','attachFiles','undo','redo',
                            ])
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('posts')
                            ->fileAttachmentsVisibility('public')
                            ->columnSpan(12),
                        \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('featured')
                            ->label('Featured Image')
                            ->collection('featured')
                            ->disk('public')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios(['16:9','4:3','1:1'])
                            ->maxFiles(1)
                            ->columnSpan(12),
                    ]),
                ]),
                Components\Tabs\Tab::make('Meta')->schema([
                    Components\Grid::make(12)->schema([
                        Forms\Components\Select::make('author_id')->options(User::query()->pluck('name','id'))->searchable()->preload()->columnSpan(4),
                        Forms\Components\Select::make('categories')->relationship('categories','name')->multiple()->preload()->columnSpan(4),
                        Forms\Components\Select::make('tags')->relationship('tags','name')->multiple()->preload()->columnSpan(4),
                        Forms\Components\TextInput::make('featured_alt')->label('Featured image alt')->maxLength(150)->columnSpan(6),
                        Forms\Components\TextInput::make('featured_credit')->label('Featured image credit')->maxLength(120)->columnSpan(6),
                        Forms\Components\Textarea::make('featured_caption')->label('Featured image caption')->rows(2)->maxLength(300)->columnSpan(12),
                    ]),
                ]),
                Components\Tabs\Tab::make('SEO')->schema([
                    Forms\Components\TextInput::make('meta_title')->maxLength(70),
                    Forms\Components\TextInput::make('meta_description')->maxLength(180),
                    Forms\Components\TextInput::make('canonical_url')->url(),
                    Forms\Components\Toggle::make('noindex'),
                ]),
                Components\Tabs\Tab::make('Publishing')->schema([
                    Forms\Components\Select::make('status')->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived'])->required(),
                    Forms\Components\DateTimePicker::make('published_at'),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(50),
            Tables\Columns\TextColumn::make('author.name')->label('Author')->sortable(),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'draft' => 'warning',
                    'published' => 'success',
                    'archived' => 'gray',
                })
                ->sortable(),
            Tables\Columns\TextColumn::make('published_at')->dateTime()->since()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived']),
        ])->actions([
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ])->bulkActions([
            Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
