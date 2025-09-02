<?php

namespace App\Filament\Resources\PotensiKonfliks;

use App\Filament\Resources\PotensiKonfliks\Pages\CreatePotensiKonflik;
use App\Filament\Resources\PotensiKonfliks\Pages\EditPotensiKonflik;
use App\Filament\Resources\PotensiKonfliks\Pages\ListPotensiKonfliks;
use App\Filament\Resources\PotensiKonfliks\Pages\ViewPotensiKonflik;
use App\Filament\Resources\PotensiKonfliks\Schemas\PotensiKonflikForm;
use App\Filament\Resources\PotensiKonfliks\Schemas\PotensiKonflikInfolist;
use App\Filament\Resources\PotensiKonfliks\Tables\PotensiKonfliksTable;
use App\Models\PotensiKonflik;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PotensiKonflikResource extends Resource
{
    protected static ?string $model = PotensiKonflik::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nama_potensi';

    public static function form(Schema $schema): Schema
    {
        return PotensiKonflikForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PotensiKonflikInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PotensiKonfliksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPotensiKonfliks::route('/'),
            'create' => CreatePotensiKonflik::route('/create'),
            'view' => ViewPotensiKonflik::route('/{record}'),
            'edit' => EditPotensiKonflik::route('/{record}/edit'),
        ];
    }
}
