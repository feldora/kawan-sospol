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
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use App\Filament\Resources\PotensiKonfliks\Schemas\Schema as schm;
use Filament\Tables\Table;


class PotensiKonflikResource extends Resource
{
    protected static ?string $model = PotensiKonflik::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $recordTitleAttribute = 'nama_potensi';

    protected static ?string $modelLabel = 'Potensi Konflik';

    protected static ?string $pluralModelLabel = 'Potensi Konflik';

    protected static ?string $navigationLabel = 'Potensi Konflik';

    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Konflik';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'potensi-konflik';

    // Menambahkan badge untuk menunjukkan jumlah data
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::count();

        if ($count > 10) {
            return 'danger';
        } elseif ($count > 5) {
            return 'warning';
        }

        return 'success';
    }

    // public static function form(Schema $schema): Schema
    // {
    //     return PotensiKonflikForm::configure($schema);
    // }
    // public static function form(Form $form): Form
    // {
    //     return $form->schema(
    //         PotensiKonflikForm::getFormSchema()
    //     );
    // }
    public static function form(Schema $schema): Schema
    {
        return $schema->components(
            PotensiKonflikForm::getFormSchema()
        );
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
            // Tambahkan relasi jika diperlukan
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

    // Global Search
    public static function getGloballySearchableAttributes(): array
    {
        return [
            'nama_potensi',
            'penanggung_jawab',
            'desa.nama',
            'desa.kecamatan.nama',
            'desa.kecamatan.kabupaten.nama'
        ];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        $details = [];

        if ($record->desa) {
            $desa = $record->desa;
            $kecamatan = $desa->kecamatan;
            $kabupaten = $kecamatan->kabupaten;

            $desaLabel = ($kabupaten->nama === 'Kota Palu') ? 'Kelurahan' : 'Desa';
            $details['Lokasi'] = $desaLabel . ' ' . $desa->nama . ', Kec. ' . $kecamatan->nama;
        }

        if ($record->tanggal_potensi) {
            $details['Tanggal'] = $record->tanggal_potensi->format('d/m/Y');
        }

        if ($record->penanggung_jawab) {
            $details['Penanggung Jawab'] = $record->penanggung_jawab;
        }

        return $details;
    }

    public static function getGlobalSearchResultUrl($record): string
    {
        return static::getUrl('view', ['record' => $record]);
    }
}
