<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public'),

                TextColumn::make('title')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                TextColumn::make('category.title')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('brand.title')
                    ->label('Brand')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('variants.name')
                    ->label('Variants')
                    ->badge()
                    ->separator(', '),

                TextColumn::make('variants_price_range')
                    ->label('Price Range')
                    ->getStateUsing(function ($record) {
                        $prices = $record->variants->pluck('price')->filter();
                        if ($prices->isEmpty()) {
                            return 'Sur Devis';
                        }
                        $min = $prices->min();
                        $max = $prices->max();
                        if ($min == $max) {
                            return number_format($min, 2) . ' €';
                        }
                        return number_format($min, 2) . ' € - ' . number_format($max, 2) . ' €';
                    }),

                ToggleColumn::make('is_active')
                    ->label('Active'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])

            ->filters([

                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'title')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('brand_id')
                    ->label('Brand')
                    ->relationship('brand', 'title')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ]),

                \Filament\Tables\Filters\TrashedFilter::make(),

            ])

            ->recordActions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
                \Filament\Actions\RestoreAction::make(),
                \Filament\Actions\ForceDeleteAction::make(),
            ])

            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                    \Filament\Actions\RestoreBulkAction::make(),
                    \Filament\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])

            ->defaultSort('created_at', 'desc');
    }
}