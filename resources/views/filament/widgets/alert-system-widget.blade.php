<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-warning-500 text-sm"></i>
                Sistem Peringatan & Monitoring
            </div>
        </x-slot>

        <div class="space-y-4">
            @if ($laporanBaru > 0)
                <div class="flex items-start gap-3 p-4 border rounded-lg bg-danger-50 border-danger-200">
                    <i class="fas fa-bell text-danger-500 text-sm flex-shrink-0 mt-0.5"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-danger-900">Laporan Belum Ditindaklanjuti</h4>
                        <p class="mt-1 text-sm text-danger-700">
                            Ada <strong>{{ $laporanBaru }}</strong> laporan berstatus "baru" lebih dari 3 hari
                            yang memerlukan tindak lanjut segera
                        </p>
                    </div>
                </div>
            @endif

            @if ($potensiMendekatTanggal > 0)
                <div class="flex items-start gap-3 p-4 border rounded-lg bg-warning-50 border-warning-200">
                    <i class="fas fa-calendar-alt text-warning-500 text-sm flex-shrink-0 mt-0.5"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-warning-900">Potensi Konflik Mendekati Tanggal</h4>
                        <p class="mt-1 text-sm text-warning-700">
                            Ada <strong>{{ $potensiMendekatTanggal }}</strong> potensi konflik yang mendekati
                            tanggal prediksi (dalam 7 hari ke depan)
                        </p>
                    </div>
                </div>
            @endif

            @if ($wilayahKonflikTinggi > 0)
                <div class="flex items-start gap-3 p-4 border border-orange-200 rounded-lg bg-orange-50">
                    <i class="fas fa-map-marker-alt text-orange-500 text-sm flex-shrink-0 mt-0.5"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-orange-900">Wilayah Rawan Konflik</h4>
                        <p class="mt-1 text-sm text-orange-700">
                            Ada <strong>{{ $wilayahKonflikTinggi }}</strong> kecamatan dengan tingkat konflik
                            tinggi (≥5 kasus). Perlu perhatian khusus untuk pencegahan.
                        </p>
                    </div>
                </div>
            @endif

            @if ($potensiTanpaLaporan > 0)
                <div class="flex items-start gap-3 p-4 border border-blue-200 rounded-lg bg-blue-50">
                    <i class="fas fa-search text-blue-500 text-sm flex-shrink-0 mt-0.5"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-blue-900">Potensi Konflik Tanpa Laporan</h4>
                        <p class="mt-1 text-sm text-blue-700">
                            Ada <strong>{{ $potensiTanpaLaporan }}</strong> potensi konflik yang belum ada laporan
                            aktualnya. Monitoring diperlukan.
                        </p>
                    </div>
                </div>
            @endif

            @if ($laporanDiteruskan > 0)
                <div class="flex items-start gap-3 p-4 border border-purple-200 rounded-lg bg-purple-50">
                    <i class="fas fa-arrow-right text-purple-500 text-sm flex-shrink-0 mt-0.5"></i>
                    <div class="flex-1">
                        <h4 class="font-semibold text-purple-900">Follow Up Diperlukan</h4>
                        <p class="mt-1 text-sm text-purple-700">
                            Ada <strong>{{ $laporanDiteruskan }}</strong> laporan yang sudah diteruskan lebih dari 7
                            hari tapi belum ada update status.
                        </p>
                    </div>
                </div>
            @endif

            @if (
                $laporanBaru == 0 &&
                    $potensiMendekatTanggal == 0 &&
                    $wilayahKonflikTinggi == 0 &&
                    $potensiTanpaLaporan == 0 &&
                    $laporanDiteruskan == 0)
                <div class="flex items-center gap-3 p-4 border rounded-lg bg-success-50 border-success-200">
                    <i class="fas fa-check-circle text-success-500 text-sm flex-shrink-0"></i>
                    <div>
                        <h4 class="font-semibold text-success-900">Situasi Terkendali</h4>
                        <p class="text-sm text-success-700">
                            Tidak ada peringatan khusus saat ini. Semua laporan sudah ditindaklanjuti dengan baik dan
                            sistem berjalan normal.
                        </p>
                    </div>
                </div>
            @endif

            <div class="pt-4 mt-4 border-t border-gray-200">
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <span>Terakhir diperbarui: {{ now()->format('d M Y H:i') }}</span>
                    <span>Auto-refresh setiap 5 menit</span>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
