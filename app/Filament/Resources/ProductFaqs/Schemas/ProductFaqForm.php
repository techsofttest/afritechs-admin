<?php

namespace App\Filament\Resources\ProductFaqs\Schemas;

use App\Models\Product;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductFaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Product FAQ')
                    ->schema([

                        Select::make('product_id')
                            ->label('Product')
                            ->options(
                                Product::query()
                                    ->whereNotNull('title')
                                    ->where('title', '!=', '')
                                    ->orderBy('title')
                                    ->pluck('title', 'id')
                                    ->map(fn ($title) => (string) $title)
                                    ->toArray()
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),

                        TextInput::make('question')
                            ->label('Question')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        RichEditor::make('answer')
                            ->label('Answer')
                            ->required()
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

                        Section::make()
                            ->schema([

                                TextInput::make('sort_order')
                                    ->label('Sort Order')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->required(),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),

                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                    ])
                    ->columns(1)
                    ->columnSpanFull(),

            ]);
    }
}