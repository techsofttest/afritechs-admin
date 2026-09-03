<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Product Details
                |--------------------------------------------------------------------------
                */

                Section::make('Product Details')
                    ->schema([

                        /*
                        |--------------------------------------------------------------------------
                        | Category & Brand
                        |--------------------------------------------------------------------------
                        */

                        Section::make()
                            ->schema([

                                Select::make('category_id')
                                    ->label('Category')
                                    ->relationship('category', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->nullable(),

                                Select::make('brand_id')
                                    ->label('Brand')
                                    ->relationship('brand', 'title')
                                    ->searchable()
                                    ->preload()
                                    ->nullable(),

                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        /*
                        |--------------------------------------------------------------------------
                        | Title & Slug
                        |--------------------------------------------------------------------------
                        */

                        Section::make()
                            ->schema([

                                TextInput::make('title')
                                    ->label('Product Title')
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

                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        /*
                        |--------------------------------------------------------------------------
                        | Description
                        |--------------------------------------------------------------------------
                        */

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

                        /*
                        |--------------------------------------------------------------------------
                        | Main Product Image
                        |--------------------------------------------------------------------------
                        */

                        Section::make()
                            ->schema([

                                FileUpload::make('image')
                                    ->label('Main Product Image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('products')
                                    ->visibility('public')
                                    ->imagePreviewHeight('250')
                                    ->openable()
                                    ->downloadable()
                                    ->imageEditor()

                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        Section::make()
                            ->schema([
                                Toggle::make('featured_status')
                                    ->label('Featured')
                                    ->default(false),

                                Toggle::make('is_flagship')
                                    ->label('Flagship Product')
                                    ->default(false),

                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),
                            ])
                            ->columns(3)
                            ->columnSpanFull(),

                    ])
                    ->columns(1)
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Product Variants
                |--------------------------------------------------------------------------
                */

                Section::make('Product Variants')
                    ->schema([

                        Repeater::make('variants')
                            ->relationship('variants')
                            ->label('Variants')
                            ->schema([

                                TextInput::make('name')
                                    ->label('Variant Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),

                                TextInput::make('sku')
                                    ->label('SKU')
                                    ->maxLength(100)
                                    ->columnSpan(2),

                                TextInput::make('price')
                                    ->label('Price')
                                    ->numeric()
                                    ->prefix('€')
                                    ->required()
                                    ->minValue(0)
                                    ->columnSpan(2),

                                TextInput::make('sale_price')
                                    ->label('Sale Price')
                                    ->numeric()
                                    ->prefix('€')
                                    ->minValue(0)
                                    ->columnSpan(2),

                            ])
                            ->columns(8)
                            ->collapsible()
                            ->itemLabel(
                                fn (array $state): ?string =>
                                    isset($state['name']) ? ($state['name'] . (isset($state['price']) ? ' (' . $state['price'] . ' €)' : '')) : 'Variant'
                            )
                            ->minItems(1)
                            ->defaultItems(1)
                            ->columnSpanFull(),

                    ])
                    ->columns(1)
                    ->columnSpanFull(),

                Section::make('Product Gallery')
                    ->schema([

                        Repeater::make('images')
                            ->relationship('images')
                            ->label('Gallery Images')
                            ->schema([

                                FileUpload::make('image')
                                    ->label('Image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('products/gallery')
                                    ->visibility('public')
                                    ->imagePreviewHeight('200')
                                    ->openable()
                                    ->downloadable()
                                    ->imageEditor()
                                    ->required()
                                    ->columnSpanFull(),

                            ])
                            ->columns(1)
                            ->orderColumn('sort_order')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(
                                fn (array $state): ?string =>
                                    $state['image'] ?? 'Gallery Image'
                            )
                            ->defaultItems(0)
                            ->columnSpanFull(),

                    ])
                    ->columns(1)
                    ->collapsible()
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Product Specifications
                |--------------------------------------------------------------------------
                */

                Section::make('Product Specifications')
                    ->schema([

                        Repeater::make('specifications')
                            ->relationship('specifications')
                            ->label('Specifications')
                            ->schema([

                                TextInput::make('name')
                                    ->label('Specification Name')
                                    ->maxLength(255)
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('value')
                                    ->label('Specification Value')
                                    ->maxLength(255)
                                    ->required()
                                    ->columnSpan(1),

                            ])
                            ->columns(2)
                            ->orderColumn('sort_order')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(
                                fn (array $state): ?string =>
                                    $state['name'] ?? 'Specification'
                            )
                            ->defaultItems(0)
                            ->columnSpanFull(),

                    ])
                    ->columns(1)
                    ->collapsible()
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Product FAQs
                |--------------------------------------------------------------------------
                */

                Section::make('Product FAQs')
                    ->schema([

                        Repeater::make('faqs')
                            ->relationship('faqs')
                            ->label('Frequently Asked Questions')
                            ->schema([

                                TextInput::make('question')
                                    ->label('Question')
                                    ->maxLength(255)
                                    ->required()
                                    ->columnSpanFull(),

                                Textarea::make('answer')
                                    ->label('Answer')
                                    ->rows(3)
                                    ->required()
                                    ->columnSpanFull(),

                            ])
                            ->columns(1)
                            ->orderColumn('sort_order')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(
                                fn (array $state): ?string =>
                                    $state['question'] ?? 'FAQ Item'
                            )
                            ->defaultItems(0)
                            ->columnSpanFull(),

                    ])
                    ->columns(1)
                    ->collapsible()
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | SEO
                |--------------------------------------------------------------------------
                */

                Section::make('SEO')
                    ->schema([

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
                                'undo',
                                'redo',
                            ]),

                    ])
                    ->columns(1)
                    ->collapsible()
                    ->columnSpanFull(),

            ]);
    }
}