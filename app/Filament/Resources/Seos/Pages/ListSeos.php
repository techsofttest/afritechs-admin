<?php

namespace App\Filament\Resources\Seos\Pages;

use App\Filament\Resources\Seos\SeoResource;
use Filament\Resources\Pages\ListRecords;

class ListSeos extends ListRecords
{
    protected static string $resource = SeoResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}