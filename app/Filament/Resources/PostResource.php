<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\{Post, Category, Tag, User};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make('Tabs')->tabs([
                Forms\Components\Tabs\Tab::make('Main')->schema([
                    Forms\Components\Grid::make(12)->schema([
                        Forms\Components\TextInput::make('title')->required()->columnSpan(8)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                if (blank($get('slug'))) {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(80)->columnSpan(4),
                        Forms\Components\Textarea::make('excerpt')->rows(3)->maxLength(350)->columnSpan(12),
                        Forms\Components\RichEditor::make('body_html')->columnSpan(12),
                    ]),
                ]),
                Forms\Components\Tabs\Tab::make('Meta')->schema([
                    Forms\Components\Grid::make(12)->schema([
                        Forms\Components\Select::make('author_id')->options(User::query()->pluck('name','id'))->searchable()->preload()->columnSpan(4),
                        Forms\Components\Select::make('categories')->relationship('categories','name')->multiple()->preload()->columnSpan(4),
                        Forms\Components\Select::make('tags')->relationship('tags','name')->multiple()->preload()->columnSpan(4),
                    ]),
                ]),
                Forms\Components\Tabs\Tab::make('SEO')->schema([
                    Forms\Components\TextInput::make('meta_title')->maxLength(70),
                    Forms\Components\TextInput::make('meta_description')->maxLength(180),
                    Forms\Components\TextInput::make('canonical_url')->url(),
                    Forms\Components\Toggle::make('noindex'),
                ]),
                Forms\Components\Tabs\Tab::make('Publishing')->schema([
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
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
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
