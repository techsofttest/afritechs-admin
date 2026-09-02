<?php

namespace App\Filament\Resources\ProductFaqs;

use App\Filament\Resources\ProductFaqs\Pages\CreateProductFaq;
use App\Filament\Resources\ProductFaqs\Pages\EditProductFaq;
use App\Filament\Resources\ProductFaqs\Pages\ListProductFaqs;
use App\Filament\Resources\ProductFaqs\Schemas\ProductFaqForm;
use App\Models\ProductFaq;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class ProductFaqResource extends Resource
{
    protected static ?string $model = ProductFaq::class;

    protected static ?string $navigationLabel = 'Product FAQs';

    protected static ?string $modelLabel = 'Product FAQ';

    protected static ?string $pluralModelLabel = 'Product FAQs';

    protected static string|\UnitEnum|null $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 3;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function form(Schema $schema): Schema
    {
        return ProductFaqForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('product.title')
                    ->label('Product')
                    ->searchable()
                    ->sortable()
                    ->limit(60),

                Tables\Columns\TextColumn::make('question')
                    ->label('Question')
                    ->searchable()
                    ->sortable()
                    ->limit(70)
                    ->wrap(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([])

            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            ->defaultSort('sort_order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductFaqs::route('/'),
            'create' => CreateProductFaq::route('/create'),
            'edit' => EditProductFaq::route('/{record}/edit'),
        ];
    }
}