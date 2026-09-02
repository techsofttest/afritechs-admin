<?php

namespace App\Filament\Resources\Seos\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Page Title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('meta_title')
                    ->label('Meta Title')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('meta_desc')
                    ->label('Meta Description')
                    ->limit(60),

                TextColumn::make('meta_key')
                    ->label('Meta Keywords')
                    ->limit(50),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}