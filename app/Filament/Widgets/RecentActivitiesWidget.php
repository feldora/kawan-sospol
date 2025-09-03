<?php

namespace App\Filament\Widgets;

use App\Models\LaporanKonflik;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivitiesWidget extends BaseWidget
{
    protected static ?string $heading = 'Aktivitas Terbaru';
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                LaporanKonflik::with(['desa.kecamatan.kabupaten'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama_pelapor')
                    ->label('Pelapor')
                    ->limit(20)
                    ->placeholder('Anonim')
                    ->searchable(),

                Tables\Columns\TextColumn::make('desa.nama')
                    ->label('Kelurahan/Desa')
                    ->placeholder('-')
                    ->searchable(),

                Tables\Columns\TextColumn::make('desa.kecamatan.nama')
                    ->label('Kecamatan')
                    ->placeholder('-')
                    ->searchable(),

                Tables\Columns\TextColumn::make('desa.kecamatan.kabupaten.nama')
                    ->label('Kabupaten')
                    ->placeholder('-')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'danger' => 'baru',
                        'warning' => 'ditindaklanjuti',
                        'success' => 'selesai',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'baru' => 'Baru',
                        'ditindaklanjuti' => 'Ditindaklanjuti',
                        'selesai' => 'Selesai',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->deskripsi;
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Laporan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->paginated(false)
            ->poll('30s');
    }
}
