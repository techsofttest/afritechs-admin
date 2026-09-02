<?php

namespace App\Filament\Resources\Seos\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SeoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->readOnly()
                    ->columnSpanFull(),

                TextInput::make('meta_title')
                    ->required()
                    ->columnSpanFull(),

                RichEditor::make('meta_desc')
                    ->label('Meta Description')
                    ->default(null)
                    ->columnSpanFull(),

                TextInput::make('meta_key')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}