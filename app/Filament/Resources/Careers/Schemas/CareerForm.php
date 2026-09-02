<?php

namespace App\Filament\Resources\Careers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class CareerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('title')
                    ->required(),

                Select::make('type')
                    ->options([
                        'job_listing' => 'Job listing',
                        'graduate_programme' => 'Graduate programme',
                        'internship' => 'Internship',
                    ])
                    ->required(),

                RichEditor::make('description')
                    ->label('Description')
                    ->default(null)
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->image()
                    ->maxSize(1024),

                TextInput::make('location')
                    ->default(null)
                    ->columnStart(1),

                DatePicker::make('application_deadline'),

                TextInput::make('application_url')
                    ->url()
                    ->default(null)
                    ->columnSpanFull(),

                Toggle::make('featured_status')
                    ->required(),

                Toggle::make('status')
                    ->required(),
                            
            ]);
    }
}