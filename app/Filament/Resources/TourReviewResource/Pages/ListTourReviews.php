<?php

namespace App\Filament\Resources\TourReviewResource\Pages;

use App\Filament\Resources\TourReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTourReviews extends ListRecords
{
    protected static string $resource = TourReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
