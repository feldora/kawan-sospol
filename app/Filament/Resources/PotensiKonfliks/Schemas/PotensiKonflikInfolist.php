<?php

namespace App\Filament\Resources\PotensiKonfliks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class PotensiKonflikInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                // Header Section with Key Information
                Section::make('')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('nama_potensi')
                                    ->label('Nama Potensi Konflik')
                                    ->columnSpan(3)
                                    ->weight('bold')
                                    ->size('lg')
                                    ->color('primary')
                                    ->icon('heroicon-o-exclamation-triangle')
                                    ->copyable(),

                                TextEntry::make('tanggal_potensi')
                                    ->label('Tanggal Identifikasi')
                                    ->date('d F Y')
                                    ->icon('heroicon-o-calendar-days')
                                    ->color('success')
                                    ->badge()
                                    ->columnSpan(1),

                                TextEntry::make('penanggung_jawab')
                                    ->label('Penanggung Jawab')
                                    ->icon('heroicon-o-user')
                                    ->color('info')
                                    ->badge()
                                    ->default('-')
                                    ->columnSpan(1),

                                TextEntry::make('status_display')
                                    ->label('Status')
                                    ->getStateUsing(fn () => 'Aktif')
                                    ->badge()
                                    ->color('warning')
                                    ->icon('heroicon-o-eye')
                                    ->columnSpan(1),
                            ]),
                    ])
                    ->compact(),

                // Location Information
                Section::make('Informasi Lokasi')
                    ->description('Detail lokasi administratif tempat potensi konflik berada')
                    ->icon('heroicon-o-map-pin')
                    ->collapsed(false)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('lokasi_detail')
                                    ->label('Lokasi Lengkap')
                                    ->getStateUsing(function ($record) {
                                        if (!$record->desa) return '-';

                                        $desa = $record->desa;
                                        $kecamatan = $desa->kecamatan;
                                        $kabupaten = $kecamatan->kabupaten;

                                        $desaLabel = ($kabupaten->nama === 'Kota Palu') ? 'Kelurahan' : 'Desa';

                                        return $desaLabel . ' ' . $desa->nama . ', Kecamatan ' . $kecamatan->nama . ', ' . $kabupaten->nama;
                                    })
                                    ->icon('heroicon-o-map-pin')
                                    ->color('success')
                                    ->copyable()
                                    ->columnSpan(2),

                                TextEntry::make('desa.kecamatan.kabupaten.nama')
                                    ->label('Kabupaten/Kota')
                                    ->icon('heroicon-o-building-office')
                                    ->badge()
                                    ->color('primary'),

                                TextEntry::make('desa.kecamatan.nama')
                                    ->label('Kecamatan')
                                    ->icon('heroicon-o-home-modern')
                                    ->badge()
                                    ->color('info'),
                            ]),
                    ]),

                // Background Details
                Section::make('Latar Belakang')
                    ->description('Penjelasan mendetail tentang potensi konflik')
                    ->icon('heroicon-o-document-text')
                    ->collapsed(false)
                    ->schema([
                        TextEntry::make('latar_belakang')
                            ->label('')
                            ->columnSpanFull()
                            ->html()
                            ->prose(),
                    ]),

                // Metadata Section
                Section::make('Informasi Sistem')
                    ->description('Data teknis dan riwayat perubahan')
                    ->icon('heroicon-o-cog')
                    ->collapsed(true)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Dibuat')
                                    ->dateTime('d F Y, H:i')
                                    ->icon('heroicon-o-plus')
                                    ->color('success'),

                                TextEntry::make('updated_at')
                                    ->label('Terakhir Diperbarui')
                                    ->dateTime('d F Y, H:i')
                                    ->icon('heroicon-o-pencil-square')
                                    ->color('warning'),
                            ]),
                    ]),
            ]);
    }
}
