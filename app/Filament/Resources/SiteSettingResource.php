<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use BackedEnum;
use UnitEnum;
use Filament\Forms;
use Filament\Schemas\Components;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;
    
    protected static ?string $navigationLabel = 'Site Settings';
    
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static string | UnitEnum | null $navigationGroup = 'Settings';
    
    protected static ?int $navigationSort = 80;
    
    protected static ?string $recordTitleAttribute = 'site_name';
    
    protected static ?string $slug = 'site-settings';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\Tabs::make('Settings')->tabs([
                
                // General Tab
                Components\Tabs\Tab::make('General')->schema([
                    Components\Section::make('Brand & Identity')->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('company_name')
                            ->label('Company Name')
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('brand_logo_path')
                            ->label('Brand Logo (Header)')
                            ->image()
                            ->disk('public')
                            ->directory('logos')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->helperText('Recommended size: 200x60px. Max 2MB.')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('brand_logo_footer_url')
                            ->label('Brand Logo (Footer)')
                            ->image()
                            ->disk('public')
                            ->directory('logos')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                null,
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->maxSize(2048)
                            ->helperText('Recommended size: 200x60px. Max 2MB.')
                            ->columnSpanFull(),
                    ])->columns(2),
                    
                    Components\Section::make('Language & Currency')->schema([
                        Forms\Components\TextInput::make('default_locale')
                            ->label('Default Locale')
                            ->default('en')
                            ->required()
                            ->maxLength(10),
                        Forms\Components\TextInput::make('main_language')
                            ->label('Main Language')
                            ->default('en')
                            ->maxLength(10),
                        Forms\Components\TextInput::make('default_currency')
                            ->label('Default Currency')
                            ->default('USD')
                            ->maxLength(10),
                        Forms\Components\Toggle::make('topbar_currency_selector_enabled')
                            ->label('Show Currency Selector in Header')
                            ->default(true),
                        Forms\Components\Toggle::make('topbar_language_selector_enabled')
                            ->label('Show Language Selector in Header')
                            ->default(true),
                    ])->columns(2),
                ]),
                
                // Contact Tab
                Components\Tabs\Tab::make('Contact')->schema([
                    Components\Section::make('Contact Information')->schema([
                        Forms\Components\TextInput::make('contact_email')
                            ->label('Contact Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_phone')
                            ->label('Contact Phone')
                            ->tel()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('contact_address_line')
                            ->label('Address Line')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_address_city')
                            ->label('City')
                            ->maxLength(100),
                        Forms\Components\TextInput::make('contact_address_country')
                            ->label('Country')
                            ->maxLength(100),
                        Forms\Components\Textarea::make('contact_blurb')
                            ->label('Contact Blurb')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])->columns(2),
                ]),
                
                // Social Media Tab
                Components\Tabs\Tab::make('Social Media')->schema([
                    Components\Section::make('Social Media Links')->schema([
                        Forms\Components\TextInput::make('social_facebook_url')
                            ->label('Facebook URL')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                        Forms\Components\TextInput::make('social_instagram_url')
                            ->label('Instagram URL')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                        Forms\Components\TextInput::make('social_x_url')
                            ->label('X (Twitter) URL')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                        Forms\Components\TextInput::make('social_youtube_url')
                            ->label('YouTube URL')
                            ->url()
                            ->prefixIcon('heroicon-o-link'),
                    ])->columns(2),
                    
                    Components\Section::make('Display Settings')->schema([
                        Forms\Components\Toggle::make('show_social_in_header')
                            ->label('Show Social Links in Header')
                            ->default(true),
                        Forms\Components\Toggle::make('show_social_in_footer')
                            ->label('Show Social Links in Footer')
                            ->default(true),
            ])->columns(2),
                ]),
                
                // Footer Tab
                Components\Tabs\Tab::make('Footer')->schema([
                    Components\Section::make('Footer Content')->schema([
                        Forms\Components\TextInput::make('footer_copyright')
                            ->label('Copyright Text')
                            ->placeholder('Copyright © 2023 Travel WP. All Rights Reserved.')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('footer_payment_badge_url')
                            ->label('Payment Badge Image')
                            ->image()
                            ->disk('public')
                            ->directory('badges')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->helperText('Upload payment methods/badges image. Max 2MB.')
                            ->columnSpanFull(),
                    ]),
                    
                    Components\Section::make('Footer Links')->schema([
                        Forms\Components\Repeater::make('footer_top_destinations')
                            ->label('Top Destinations')
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('url')
                                    ->required()
                                    ->url(),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->addActionLabel('Add Destination'),
                        
                        Forms\Components\Repeater::make('footer_information_links')
                            ->label('Information Links')
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('url')
                                    ->required()
                                    ->url(),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->addActionLabel('Add Link'),
                    ]),
                ]),
                
                // Map Tab
                Components\Tabs\Tab::make('Map')->schema([
                    Components\Section::make('Map Embed')->schema([
                        Forms\Components\Textarea::make('map_iframe_src')
                            ->label('Map iframe src URL')
                            ->placeholder('https://maps.google.com/maps?q=new%20york&t=m&z=10&output=embed&iwloc=near')
                            ->rows(3)
                            ->helperText('Paste the Google Maps embed URL (just the src attribute value)')
                            ->columnSpanFull(),
                    ]),
                ]),
                
                // Contact Form Tab
                Components\Tabs\Tab::make('Contact Form')->schema([
                    Components\Section::make('Email Recipients')->schema([
                        Forms\Components\TextInput::make('contact_send_to_email')
                            ->label('Send To Email')
                            ->email()
                            ->helperText('Primary recipient for contact form submissions')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('contact_send_cc')
                            ->label('CC Email')
                            ->email()
                            ->helperText('Carbon copy recipient (optional)')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('contact_send_bcc')
                            ->label('BCC Email')
                            ->email()
                            ->helperText('Blind carbon copy recipient (optional)')
                            ->columnSpanFull(),
                    ]),
                    
                    Components\Section::make('Auto-Reply Settings')->schema([
                        Forms\Components\Toggle::make('contact_auto_reply_enabled')
                            ->label('Enable Auto-Reply')
                            ->default(false)
                            ->live(),
                        Forms\Components\TextInput::make('contact_auto_reply_subject')
                            ->label('Auto-Reply Subject')
                            ->maxLength(255)
                            ->default('Thank you for contacting us')
                            ->visible(fn ($get) => $get('contact_auto_reply_enabled')),
                        Forms\Components\Textarea::make('contact_auto_reply_body')
                            ->label('Auto-Reply Body')
                            ->rows(5)
                            ->default('Thank you for reaching out to us. We have received your message and will get back to you shortly.')
                            ->visible(fn ($get) => $get('contact_auto_reply_enabled'))
                            ->columnSpanFull(),
                    ]),
                ]),
                
                // SEO & Security Tab
                Components\Tabs\Tab::make('SEO & Security')->schema([
                    Components\Section::make('Default SEO Meta')->schema([
                Forms\Components\KeyValue::make('default_meta')
                            ->label('Default Meta Tags')
                    ->keyLabel('Key')
                    ->valueLabel('Value')
                            ->addButtonLabel('Add Meta Tag')
                            ->columnSpanFull(),
                    ]),
                    
                    Components\Section::make('reCAPTCHA')->schema([
                        Forms\Components\TextInput::make('recaptcha_site_key')
                            ->label('reCAPTCHA Site Key')
                            ->password()
                            ->revealable()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('recaptcha_secret_key')
                            ->label('reCAPTCHA Secret Key')
                            ->password()
                            ->revealable()
                            ->maxLength(255),
                    ])->columns(2),
                ]),
                
                // About Page Tab
                Components\Tabs\Tab::make('About Page')->schema([
                    Components\Section::make('Hero Section')->schema([
                        Forms\Components\FileUpload::make('about_hero_bg_image')
                            ->label('Hero Background Image')
                            ->image()
                            ->disk('public')
                            ->directory('about')
                            ->imageEditor()
                            ->maxSize(5120)
                            ->helperText('Recommended: 1920x600px'),
                        Forms\Components\TextInput::make('about_hero_title')
                            ->label('Hero Title')
                            ->default('About us')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('about_hero_subtitle')
                            ->label('Hero Subtitle')
                            ->default('Let\'s explore what we do!')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('about_hero_video_url')
                            ->label('Hero Video URL')
                            ->url()
                            ->helperText('YouTube or Vimeo URL - leave empty to hide play button'),
                    ])->columns(2),
                    
                    Components\Section::make('Provide Best Travel Experience')->schema([
                        Forms\Components\TextInput::make('about_provide_title')
                            ->label('Section Title')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('about_provide_text')
                            ->label('Section Text')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                    
                    Components\Section::make('Vision & Mission Cards')->schema([
                        Forms\Components\TextInput::make('about_vision_title')
                            ->label('Vision Title')
                            ->default('Our Vision')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('about_vision_text')
                            ->label('Vision Text')
                            ->rows(3),
                        Forms\Components\FileUpload::make('about_vision_icon')
                            ->label('Vision Icon')
                            ->image()
                            ->disk('public')
                            ->directory('icons')
                            ->maxSize(1024),
                        Forms\Components\TextInput::make('about_mission_title')
                            ->label('Mission Title')
                            ->default('Our Mission')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('about_mission_text')
                            ->label('Mission Text')
                            ->rows(3),
                        Forms\Components\FileUpload::make('about_mission_icon')
                            ->label('Mission Icon')
                            ->image()
                            ->disk('public')
                            ->directory('icons')
                            ->maxSize(1024),
                    ])->columns(2),
                    
                    Components\Section::make('Dream Destination Section')->schema([
                        Forms\Components\TextInput::make('about_dream_title')
                            ->label('Section Title')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('about_dream_text')
                            ->label('Section Text')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('about_dream_features')
                            ->label('Features (max 4)')
                            ->schema([
                                Forms\Components\TextInput::make('icon')
                                    ->label('Icon Name')
                                    ->placeholder('e.g., solar:star-bold'),
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\Textarea::make('text')
                                    ->rows(2)
                                    ->maxLength(500),
                            ])
                            ->columns(3)
                            ->defaultItems(0)
                            ->maxItems(4)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),
                    
                    Components\Section::make('Enjoy Exclusive Personalized Service')->schema([
                        Forms\Components\TextInput::make('about_enjoy_title')
                            ->label('Section Title')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('about_enjoy_text')
                            ->label('Section Text')
                            ->rows(4),
                        Forms\Components\FileUpload::make('about_enjoy_image')
                            ->label('Section Image')
                            ->image()
                            ->disk('public')
                            ->directory('about')
                            ->imageEditor()
                            ->maxSize(3072)
                            ->helperText('Recommended: 800x600px'),
                    ])->columns(2),
                    
                    Components\Section::make('Team Members')->schema([
                        Forms\Components\Repeater::make('about_team_members')
                            ->label('Team Gallery')
                            ->schema([
                                Forms\Components\FileUpload::make('photo')
                                    ->image()
                                    ->disk('public')
                                    ->directory('team')
                                    ->imageEditor()
                                    ->maxSize(2048),
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(100),
                                Forms\Components\TextInput::make('role')
                                    ->required()
                                    ->maxLength(100),
                            ])
                            ->columns(3)
                            ->reorderable()
                            ->columnSpanFull()
                            ->defaultItems(0)
                            ->collapsed(),
                    ]),
                    
                    Components\Section::make('Contact Tiles')->schema([
                        Forms\Components\TextInput::make('about_contact_email_label')
                            ->label('Email Label')
                            ->default('Email')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('about_contact_email')
                            ->label('Email Address')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('about_contact_phone_label')
                            ->label('Phone Label')
                            ->default('Phone')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('about_contact_phone')
                            ->label('Phone Number')
                            ->tel()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('about_contact_location_label')
                            ->label('Location Label')
                            ->default('Location')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('about_contact_location')
                            ->label('Location Address')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('about_contact_location_map_url')
                            ->label('Google Maps URL')
                            ->url()
                            ->helperText('URL for "View on Google Map" link')
                            ->columnSpanFull(),
                    ])->columns(2),
                    
                    Components\Section::make('CTA Form Section')->schema([
                        Forms\Components\Toggle::make('about_cta_enabled')
                            ->label('Enable CTA Form')
                            ->default(true)
                            ->live(),
                        Forms\Components\Toggle::make('about_cta_uses_contact_form')
                            ->label('Use Contact Form Logic')
                            ->default(true)
                            ->helperText('If enabled, form submits to contact handler')
                            ->visible(fn ($get) => $get('about_cta_enabled')),
                        Forms\Components\TextInput::make('about_cta_title')
                            ->label('CTA Title')
                            ->maxLength(255)
                            ->visible(fn ($get) => $get('about_cta_enabled'))
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('about_cta_text')
                            ->label('CTA Text')
                            ->rows(3)
                            ->visible(fn ($get) => $get('about_cta_enabled'))
                            ->columnSpanFull(),
                    ]),
                ]),
            ])->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('site_name')
                ->searchable(),
            Tables\Columns\TextColumn::make('contact_email')
                ->searchable(),
            Tables\Columns\TextColumn::make('default_locale'),
            Tables\Columns\IconColumn::make('contact_auto_reply_enabled')
                ->label('Auto-Reply')
                ->boolean(),
        ])->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSiteSettings::route('/'),
        ];
    }
}
