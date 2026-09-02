<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Service Details')
                    ->schema([

                        TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->readOnly(),

                        RichEditor::make('description')
                            ->label('Description')
                            ->columnSpanFull(),

                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        RichEditor::make('meta_desc')
                            ->label('Meta Description')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'link',
                                'bulletList',
                                'orderedList',
                                'undo',
                                'redo',
                            ]),

                        TextInput::make('meta_key')
                            ->label('Meta Keywords')
                            ->maxLength(255)
                            ->columnSpanFull(),    

                        FileUpload::make('image')
                            ->label('Image')
                            ->image()
                            ->disk('public')
                            ->directory('services')
                            ->visibility('public')
                            ->imageEditor(),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Status')
                    ->schema([

                        Toggle::make('featured_status')
                            ->label('Featured Status')
                            ->default(false)
                            ->required(),

                        Toggle::make('status')
                            ->label('Status')
                            ->default(true)
                            ->required(),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

            ]);
    }
}