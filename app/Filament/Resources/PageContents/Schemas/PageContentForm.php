<?php

namespace App\Filament\Resources\PageContents\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class PageContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Page Information')
                    ->schema([

                        TextInput::make('key')
                            ->label('Page Key (Identifier)')
                            ->required()
                            ->maxLength(100)
                            ->unique(ignoreRecord: true)
                            ->disabled(fn ($record) => $record !== null),

                        TextInput::make('title')
                            ->label('Page Title')
                            ->required()
                            ->maxLength(255),

                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Tabs::make('Sections')
                    ->tabs([

                        /*
                        |--------------------------------------------------------------------------
                        | Hero & Profile Tab
                        |--------------------------------------------------------------------------
                        */
                        Tabs\Tab::make('Hero & Profile')
                            ->schema([

                                Section::make('Hero Banner')
                                    ->schema([

                                        Textarea::make('content.hero.title')
                                            ->label('Hero Title')
                                            ->rows(2)
                                            ->columnSpanFull(),

                                        Textarea::make('content.hero.subtitle')
                                            ->label('Hero Subtitle')
                                            ->rows(2)
                                            ->columnSpanFull(),

                                        FileUpload::make('content.hero.image')
                                            ->label('Hero Image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('pages/hero')
                                            ->columnSpanFull(),

                                    ])
                                    ->collapsible(),

                                Section::make('Company Profile')
                                    ->schema([

                                        TextInput::make('content.profile.section_title')
                                            ->label('Section Title')
                                            ->columnSpanFull(),

                                        TextInput::make('content.profile.heading')
                                            ->label('Heading')
                                            ->columnSpanFull(),

                                        Textarea::make('content.profile.p1')
                                            ->label('Paragraph 1')
                                            ->rows(4)
                                            ->columnSpanFull(),

                                        Textarea::make('content.profile.p2')
                                            ->label('Paragraph 2')
                                            ->rows(4)
                                            ->columnSpanFull(),

                                        FileUpload::make('content.profile.image')
                                            ->label('Profile Image')
                                            ->image()
                                            ->disk('public')
                                            ->directory('pages/profile')
                                            ->columnSpanFull(),

                                    ])
                                    ->collapsible(),

                            ]),

                        /*
                        |--------------------------------------------------------------------------
                        | Mission, Vision & Core Values Tab
                        |--------------------------------------------------------------------------
                        */
                        Tabs\Tab::make('Mission, Vision & Values')
                            ->schema([

                                Section::make('Mission & Vision')
                                    ->schema([

                                        TextInput::make('content.mission_vision.mission_title')
                                            ->label('Mission Title'),

                                        Textarea::make('content.mission_vision.mission_desc')
                                            ->label('Mission Description')
                                            ->rows(3),

                                        TextInput::make('content.mission_vision.vision_title')
                                            ->label('Vision Title'),

                                        Textarea::make('content.mission_vision.vision_desc')
                                            ->label('Vision Description')
                                            ->rows(3),

                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                Section::make('Core Values')
                                    ->schema([

                                        TextInput::make('content.values.section_title')
                                            ->label('Section Title')
                                            ->columnSpanFull(),

                                        Repeater::make('content.values.items')
                                            ->label('Value Items')
                                            ->schema([

                                                TextInput::make('title')
                                                    ->label('Title')
                                                    ->required(),

                                                Textarea::make('desc')
                                                    ->label('Description')
                                                    ->rows(2)
                                                    ->required(),

                                                Select::make('icon')
                                                    ->label('Icon')
                                                    ->options([
                                                        'dependability' => 'Dependability (Users)',
                                                        'satisfaction' => 'Customer Satisfaction (Heart)',
                                                        'uniqueness' => 'Uniqueness (Lightbulb)',
                                                        'cost' => 'Cost Effectiveness (Dollar)',
                                                    ])
                                                    ->default('dependability'),

                                            ])
                                            ->columns(3)
                                            ->reorderable()
                                            ->collapsible()
                                            ->columnSpanFull(),

                                    ])
                                    ->collapsible(),

                            ]),

                        /*
                        |--------------------------------------------------------------------------
                        | Chairman & Leadership Team Tab
                        |--------------------------------------------------------------------------
                        */
                        Tabs\Tab::make('Leadership Team')
                            ->schema([

                                Section::make("Chairman's Message")
                                    ->schema([

                                        TextInput::make('content.chairman.heading')
                                            ->label('Heading')
                                            ->columnSpanFull(),

                                        Textarea::make('content.chairman.quote')
                                            ->label('Quote / Message')
                                            ->rows(4)
                                            ->columnSpanFull(),

                                        TextInput::make('content.chairman.name')
                                            ->label('Name'),

                                        TextInput::make('content.chairman.role')
                                            ->label('Role / Title'),

                                        FileUpload::make('content.chairman.photo')
                                            ->label('Photo')
                                            ->image()
                                            ->disk('public')
                                            ->directory('pages/chairman')
                                            ->columnSpanFull(),

                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                Section::make('Leadership Team Members')
                                    ->schema([

                                        TextInput::make('content.team.section_title')
                                            ->label('Section Title')
                                            ->columnSpanFull(),

                                        Repeater::make('content.team.members')
                                            ->label('Team Members')
                                            ->schema([

                                                TextInput::make('name')
                                                    ->label('Member Name')
                                                    ->required(),

                                                TextInput::make('role')
                                                    ->label('Role / Position')
                                                    ->required(),

                                                FileUpload::make('photo')
                                                    ->label('Photo')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('pages/team'),

                                            ])
                                            ->columns(3)
                                            ->reorderable()
                                            ->collapsible()
                                            ->columnSpanFull(),

                                    ])
                                    ->collapsible(),

                            ]),

                        /*
                        |--------------------------------------------------------------------------
                        | Governance, Policies & CSR Tab
                        |--------------------------------------------------------------------------
                        */
                        Tabs\Tab::make('Governance & Policies')
                            ->schema([

                                Section::make("Corporate Governance")
                                    ->schema([

                                        TextInput::make('content.governance.section_title')
                                            ->label('Section Title')
                                            ->columnSpanFull(),

                                        Textarea::make('content.governance.desc')
                                            ->label('Governance Description')
                                            ->rows(3)
                                            ->columnSpanFull(),

                                    ])
                                    ->collapsible(),

                                Section::make('Quality & Safety Policies')
                                    ->schema([

                                        TextInput::make('content.quality_security.quality_title')
                                            ->label('Quality Policy Title'),

                                        Textarea::make('content.quality_security.quality_desc')
                                            ->label('Quality Policy Description')
                                            ->rows(3),

                                        TextInput::make('content.quality_security.hse_title')
                                            ->label('HSE Policy Title'),

                                        Textarea::make('content.quality_security.hse_desc')
                                            ->label('HSE Policy Description')
                                            ->rows(3),

                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                Section::make('CSR (Corporate Social Responsibility)')
                                    ->schema([

                                        TextInput::make('content.csr.title')
                                            ->label('CSR Title')
                                            ->columnSpanFull(),

                                        Textarea::make('content.csr.desc')
                                            ->label('CSR Description')
                                            ->rows(3)
                                            ->columnSpanFull(),

                                    ])
                                    ->collapsible(),

                            ]),

                        /*
                        |--------------------------------------------------------------------------
                        | SEO Tab
                        |--------------------------------------------------------------------------
                        */
                        Tabs\Tab::make('SEO')
                            ->schema([

                                TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->columnSpanFull(),

                                Textarea::make('meta_desc')
                                    ->label('Meta Description')
                                    ->rows(3)
                                    ->columnSpanFull(),

                            ]),

                    ])
                    ->columnSpanFull(),

            ]);
    }
}
