<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\{Post, Category, Tag, User};
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\RichEditor;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\Toggle;
use Filament\Schemas\Components\DateTimePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';
    protected static string | \UnitEnum | null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make('Tabs')->tabs([
                Tab::make('Main')->schema([
                    Grid::make(12)->schema([
                        TextInput::make('title')->required()->columnSpan(8)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                if (blank($get('slug'))) {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(80)->columnSpan(4),
                        Textarea::make('excerpt')->rows(3)->maxLength(350)->columnSpan(12),
                        RichEditor::make('body_html')->columnSpan(12),
                    ]),
                ]),
                Tab::make('Meta')->schema([
                    Grid::make(12)->schema([
                        Select::make('author_id')->options(User::query()->pluck('name','id'))->searchable()->preload()->columnSpan(4),
                        Select::make('categories')->relationship('categories','name')->multiple()->preload()->columnSpan(4),
                        Select::make('tags')->relationship('tags','name')->multiple()->preload()->columnSpan(4),
                    ]),
                ]),
                Tab::make('SEO')->schema([
                    TextInput::make('meta_title')->maxLength(70),
                    TextInput::make('meta_description')->maxLength(180),
                    TextInput::make('canonical_url')->url(),
                    Toggle::make('noindex'),
                ]),
                Tab::make('Publishing')->schema([
                    Select::make('status')->options(['draft'=>'Draft','published'=>'Published','archived'=>'Archived'])->required(),
                    DateTimePicker::make('published_at'),
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
        ])->recordActions([
            EditAction::make(),
            DeleteAction::make(),
        ])->bulkActions([
            BulkActionGroup::make([DeleteBulkAction::make()]),
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
