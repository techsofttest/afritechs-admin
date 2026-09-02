<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', Str::slug($state));
                    })
                    ->columnSpanFull(),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(
                        table: 'news',
                        column: 'slug',
                        ignoreRecord: true
                    )
                    ->columnSpanFull(),

                RichEditor::make('description')
                    ->label('Description')
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('News Image')
                    ->image()
                    ->disk('public')
                    ->directory('news')
                    ->visibility('public')
                    ->imagePreviewHeight('250')
                    ->openable()
                    ->downloadable()
                    ->imageEditor(),

                Toggle::make('status')
                    ->label('Active')
                    ->default(true)
                    ->columnSpanFull(),

            ]);
    }
}