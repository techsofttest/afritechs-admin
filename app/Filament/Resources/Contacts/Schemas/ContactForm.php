<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                RichEditor::make('address')
                    ->label('Address')
                    ->default(null)
                    ->columnSpanFull(),

                Textarea::make('map_link')
                    ->label('Map Link')
                    ->default(null)
                    ->columnSpanFull(),

                TextInput::make('phone')
                    ->tel()
                    ->default(null),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->default(null),

                TextInput::make('whatsapp')
                    ->tel()
                    ->default(null),

                TextInput::make('opening_hours')
                    ->default(null),

                TextInput::make('facebook')
                    ->url()
                    ->default(null),

                TextInput::make('twitter')
                    ->url()
                    ->default(null),

                TextInput::make('instagram')
                    ->url()
                    ->default(null),

                TextInput::make('linkedin')
                    ->url()
                    ->default(null),

                TextInput::make('youtube')
                    ->url()
                    ->default(null),
            ]);
    }
}