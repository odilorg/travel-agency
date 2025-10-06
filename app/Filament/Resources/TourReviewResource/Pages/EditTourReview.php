<?php

namespace App\Filament\Resources\TourReviewResource\Pages;

use App\Filament\Resources\TourReviewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTourReview extends EditRecord
{
    protected static string $resource = TourReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
