<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class ManageSiteSettings extends EditRecord
{
    protected static string $resource = SiteSettingResource::class;
    
    protected static ?string $navigationLabel = 'Site Settings';

    public function mount(int | string $record = null): void
    {
        // Always load the singleton instance (ID = 1)
        $this->record = SiteSetting::getInstance();
        
        $this->authorizeAccess();

        $this->fillForm();

        $this->previousUrl = url()->previous();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_contact_page')
                ->label('View Contact Page')
                ->icon('heroicon-o-eye')
                ->url(route('contact'))
                ->openUrlInNewTab(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Settings saved successfully';
    }
}
