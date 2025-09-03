<?php

namespace App\Filament\Resources\PotensiKonfliks\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Post;
use App\Models\JenisKonflik;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;


class PotensiKonfliksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_potensi', 'desc')
            ->striped()
            ->columns([
                TextColumn::make('nama_potensi')
                    ->label('Nama Potensi')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->color('primary')
                    ->copyable()
                    ->copyMessage('Nama potensi disalin')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->nama_potensi)
                    ->wrap(),

                TextColumn::make('jenisKonflik.nama')
                    ->label('Jenis Konflik')
                    ->badge()
                    ->color('primary')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('tanggal_potensi')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color('gray')
                    ->alignCenter(),

                TextColumn::make('lokasi_lengkap')
                    ->label('Lokasi')
                    ->getStateUsing(function ($record) {
                        if (!$record->desa) return '-';

                        $desa = $record->desa;
                        $kecamatan = $desa->kecamatan;
                        $kabupaten = $kecamatan->kabupaten;

                        $desaLabel = ($kabupaten->nama === 'Kota Palu') ? 'Kel.' : 'Desa';

                        return $desaLabel . ' ' . $desa->nama . ', Kec. ' . $kecamatan->nama;
                    })
                    ->color('success')
                    ->searchable(['desa.nama', 'desa.kecamatan.nama', 'desa.kecamatan.kabupaten.nama'])
                    ->limit(40)
                    ->tooltip(function ($record) {
                        if (!$record->desa) return '-';

                        $desa = $record->desa;
                        $kecamatan = $desa->kecamatan;
                        $kabupaten = $kecamatan->kabupaten;

                        $desaLabel = ($kabupaten->nama === 'Kota Palu') ? 'Kelurahan' : 'Desa';

                        return $desaLabel . ' ' . $desa->nama . ', Kecamatan ' . $kecamatan->nama . ', ' . $kabupaten->nama;
                    })
                    ->wrap(),

                TextColumn::make('penanggung_jawab')
                    ->label('Penanggung Jawab')
                    ->searchable()
                    ->color('info')
                    ->placeholder('-')
                    ->limit(30)
                    ->wrap(),

                BadgeColumn::make('status_badge')
                    ->label('Status')
                    ->getStateUsing(fn () => 'Aktif')
                    ->color('warning'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),

                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray'),
            ])
            ->filters([
                SelectFilter::make('jenis_konflik_id')
                    ->label('Jenis Konflik')
                    ->options(JenisKonflik::pluck('nama', 'id'))
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('kabupaten')
                    ->label('Kabupaten/Kota')
                    ->relationship('desa.kecamatan.kabupaten', 'nama')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('kecamatan')
                    ->label('Kecamatan')
                    ->relationship('desa.kecamatan', 'nama')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Filter::make('tanggal_range')
                    ->form([
                        DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal')
                            ->displayFormat('d/m/Y'),
                        DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal')
                            ->displayFormat('d/m/Y'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_potensi', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_potensi', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['dari_tanggal'] ?? null) {
                            $indicators[] = 'Dari: ' . \Carbon\Carbon::parse($data['dari_tanggal'])->format('d/m/Y');
                        }

                        if ($data['sampai_tanggal'] ?? null) {
                            $indicators[] = 'Sampai: ' . \Carbon\Carbon::parse($data['sampai_tanggal'])->format('d/m/Y');
                        }

                        return $indicators;
                    }),

                Filter::make('bulan_ini')
                    ->query(fn (Builder $query): Builder => $query->whereMonth('tanggal_potensi', now()->month))
                    ->toggle(),
            ])
            ->actions([
                ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->color('info'),

                EditAction::make()
                    ->label('Ubah')
                    ->icon('heroicon-m-pencil-square')
                    ->color('warning'),
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Hapus Terpilih')
                        ->icon('heroicon-m-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Data Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus data yang dipilih? Tindakan ini tidak dapat dibatalkan.')
                        ->modalSubmitActionLabel('Hapus'),
                ])
                    ->label('Aksi Massal'),
            ])
            ->emptyStateHeading('Belum ada data potensi konflik')
            ->emptyStateDescription('Mulai dengan menambahkan potensi konflik pertama Anda.')
            ->emptyStateIcon('heroicon-o-exclamation-triangle')
            ->emptyStateActions([
                CreateAction::make()
                    ->label('Tambah Potensi Konflik')
                    ->icon('heroicon-m-plus')
                    ->color('primary'),
            ])
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25)
            ->poll('30s')
            ->deferLoading()
            ->persistFiltersInSession()
            ->persistSortInSession();
    }
}
