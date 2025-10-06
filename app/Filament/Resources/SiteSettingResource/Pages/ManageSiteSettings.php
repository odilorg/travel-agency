<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use Filament\Resources\Pages\ManageRecords;

class ManageSiteSettings extends ManageRecords
{
    protected static string $resource = SiteSettingResource::class;
    protected static ?string $navigationLabel = 'Site Settings';

    protected function getHeaderActions(): array
    {
        return [];
    }
}
