<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->default(null),

                TextInput::make('cms_title')
                    ->default(null),

                RichEditor::make('content1')
                    ->label(fn ($record) => $record?->id === 1 ? 'Content' : 'Content 1')
                    ->default(null)
                    ->columnSpanFull(),

                RichEditor::make('content2')
                    ->label('Content 2')
                    ->default(null)
                    ->columnSpanFull()
                    ->hidden(fn ($record) => $record?->id === 1),

                FileUpload::make('image')
                    ->image()
                    ->hidden(fn ($record) => $record?->id === 1),
            ]);
    }
}