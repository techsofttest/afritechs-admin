<?php

namespace App\Filament\Resources\Seos\Pages;

use App\Filament\Resources\Seos\SeoResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditSeo extends EditRecord
{
    protected static string $resource = SeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back')
                ->icon('heroicon-o-arrow-left')
                ->url(SeoResource::getUrl('index')),
        ];
    }
}