<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /*
                |--------------------------------------------------------------------------
                | Project Details
                |--------------------------------------------------------------------------
                */

                Section::make('Project Details')
                    ->schema([

                        Select::make('service_id')
                            ->label('Service')
                            ->relationship('service', 'title')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),

                        /*
                        |--------------------------------------------------------------------------
                        | Title & Slug
                        |--------------------------------------------------------------------------
                        */

                        Section::make()
                            ->schema([
                            TextInput::make('title')
                                ->label('Project Title')
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
                        | Location & Main Image
                        |--------------------------------------------------------------------------
                        */

                        Section::make()
                            ->schema([

                                FileUpload::make('image')
                                    ->label('Main Project Image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('projects')
                                    ->visibility('public')
                                    ->imagePreviewHeight('250')
                                    ->openable()
                                    ->downloadable()
                                    ->imageEditor()
                                    ->maxSize(1024),

                                TextInput::make('location')
                                    ->label('Location')
                                    ->maxLength(255),    

                            ])
                            ->columns(2)
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

                        Section::make()
                            ->schema([
                                Toggle::make('status')
                                    ->label('Active')
                                    ->default(true),

                                Toggle::make('is_flagship')
                                    ->label('Flagship Project')
                                    ->default(false),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                    ])
                    ->columns(1)
                    ->columnSpanFull(),

                /*
                |--------------------------------------------------------------------------
                | Project Gallery
                |--------------------------------------------------------------------------
                */

                Section::make('Project Gallery')
                    ->schema([

                        Repeater::make('images')
                            ->relationship('images')
                            ->label('Gallery Images')
                            ->schema([

                                FileUpload::make('image')
                                    ->label('Image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('projects/gallery')
                                    ->visibility('public')
                                    ->imagePreviewHeight('200')
                                    ->openable()
                                    ->downloadable()
                                    ->imageEditor()
                                    ->maxSize(1024)
                                    ->required()
                                    ->columnSpan(1),

                                TextInput::make('sort_order')
                                    ->label('Sort Order')
                                    ->numeric()
                                    ->default(0)
                                    ->columnSpan(1),

                            ])
                            ->columns(2)
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

                        TextInput::make('meta_key')
                            ->label('Meta Keywords')
                            ->maxLength(255)
                            ->columnSpanFull(),

                    ])
                    ->columns(1)
                    ->collapsible()
                    ->columnSpanFull(),

            ]);
    }
}