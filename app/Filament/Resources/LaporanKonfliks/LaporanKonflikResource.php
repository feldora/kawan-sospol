<?php

namespace App\Filament\Resources\LaporanKonfliks;

use BackedEnum;
use UnitEnum;
use App\Filament\Resources\LaporanKonfliks\Pages;
use App\Filament\Resources\LaporanKonfliks\Schemas\LaporanKonflikForm;
use App\Filament\Resources\LaporanKonfliks\Schemas\LaporanKonflikInfolist;
use App\Filament\Resources\LaporanKonfliks\Tables\LaporanKonfliksTable;
use App\Models\LaporanKonflik;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Filament\Schemas\Schema;

class LaporanKonflikResource extends Resource
{
    protected static ?string $model = LaporanKonflik::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-exclamation-circle';
    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Konflik';
    protected static ?string $navigationLabel = 'Laporan Konflik';
    protected static ?string $pluralModelLabel = 'Laporan Konflik';

    public static function form(Schema $schema): Schema
    {
        return LaporanKonflikForm::schema($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LaporanKonflikInfolist::schema($schema);
    }

public static function table(Table $table): Table
{
    return LaporanKonfliksTable::configure($table);
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporanKonfliks::route('/'),
            'create' => Pages\CreateLaporanKonflik::route('/create'),
            'view' => Pages\ViewLaporanKonflik::route('/{record}'),
            'edit' => Pages\EditLaporanKonflik::route('/{record}/edit'),
        ];
    }

    public static function getRecordTitle(?Model $record): Htmlable|string|null
    {
        if (! $record) {
            return null;
        }

        return trim("{$record->nama_pelapor} - {$record->lokasi_text}", ' -');
}
}
