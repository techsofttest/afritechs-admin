<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('placed_at')
                    ->label('Date & Time')
                    ->dateTime('M j, Y g:i A')
                    ->sortable(),

                TextColumn::make('order_number')
                    ->label('Enquiry #')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('customer_name')
                    ->label('Name')
                    ->state(fn ($record) => trim(($record->billing_address['first_name'] ?? '') . ' ' . ($record->billing_address['last_name'] ?? '')) ?: ($record->customer_name ?? ''))
                    ->searchable(),

                TextColumn::make('customer_email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('customer_phone')
                    ->label('Phone')
                    ->searchable(),

                TextColumn::make('country')
                    ->label('Country')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('items_count')
                    ->label('Total Items')
                    ->counts('items'),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'processing' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->defaultSort('placed_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
