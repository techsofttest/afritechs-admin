<?php

namespace App\Filament\Resources\PageContents;

use App\Filament\Resources\PageContents\Pages\CreatePageContent;
use App\Filament\Resources\PageContents\Pages\EditPageContent;
use App\Filament\Resources\PageContents\Pages\ListPageContents;
use App\Filament\Resources\PageContents\Schemas\PageContentForm;
use App\Filament\Resources\PageContents\Tables\PageContentsTable;
use App\Models\PageContent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PageContentResource extends Resource
{
    protected static ?string $model = PageContent::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'Page Content';

    protected static ?string $pluralModelLabel = 'Page Contents';

    protected static ?string $navigationLabel = 'Dynamic Pages';

    protected static ?int $navigationSort = 5;

    protected static string|UnitEnum|null $navigationGroup = 'Content Management';

    public static function form(Schema $schema): Schema
    {
        return PageContentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PageContentsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPageContents::route('/'),
            'create' => CreatePageContent::route('/create'),
            'edit' => EditPageContent::route('/{record}/edit'),
        ];
    }
}
