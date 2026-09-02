<?php

namespace App\Filament\Resources\HeroSliders\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class HeroSliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                RichEditor::make('description')
                    ->label('Description')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'link',
                        'bulletList',
                        'orderedList',
                        'blockquote',
                        'h2',
                        'h3',
                        'undo',
                        'redo',
                    ]),

                FileUpload::make('image')
                    ->label('Hero Image')
                    ->image()
                    ->disk('public')
                    ->directory('hero-sliders')
                    ->visibility('public')
                    ->imagePreviewHeight('250')
                    ->openable()
                    ->downloadable()
                    ->required()
                    ->columnSpanFull()
                    ->columnSpan(1),

                Toggle::make('status')
                    ->label('Active')
                    ->default(true)
                    ->columnSpanFull(),

            ]);
    }
}