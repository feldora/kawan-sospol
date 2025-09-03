<?php

namespace App\Filament\Resources\LaporanKonfliks\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\LaporanKonfliks\LaporanKonflikResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class LaporanKonfliksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
Tables\Columns\TextColumn::make('pelapor_lokasi')
    ->label('Pelapor & Lokasi')
    ->getStateUsing(fn ($record) => "
        <div>
            <div><strong>{$record->nama_pelapor}</strong></div>
            <div style='color: #6b7280; font-size: 0.875rem;'>{$record->lokasi_text}</div>
        </div>
    ")
    ->html()
    ->searchable(query: function ($query, $search) {
        return $query
            ->where('nama_pelapor', 'like', "%{$search}%")
            ->orWhere('lokasi_text', 'like', "%{$search}%");
    })
    ->sortable(query: fn ($query, $direction) => $query->orderBy('nama_pelapor', $direction)),

                // Tables\Columns\TextColumn::make('nama_pelapor')
                //     ->label('Pelapor')
                //     ->searchable()
                //     ->sortable(),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->searchable()
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->deskripsi),
                    // ->wrap(),

                // Tables\Columns\TextColumn::make('lokasi_text')
                //     ->label('Lokasi')
                //     ->limit(40),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'baru' => 'Baru',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                        default => $state,
                    })
                    ->colors([
                        'primary' => ['baru'],
                        'warning' => ['diproses'],
                        'success' => ['selesai'],
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dilaporkan')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')->options([
                    'baru' => 'Baru',
                    'diproses' => 'Diproses',
                    'selesai' => 'Selesai',
                ]),
            ])
            ->recordActions([
                ViewAction::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => LaporanKonflikResource::getUrl('view', ['record' => $record])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
