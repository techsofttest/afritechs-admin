<?php

namespace App\Filament\Resources\ProductFaqs\Pages;

use App\Filament\Resources\ProductFaqs\ProductFaqResource;
use Filament\Resources\Pages\EditRecord;

class EditProductFaq extends EditRecord
{
    protected static string $resource = ProductFaqResource::class;
}