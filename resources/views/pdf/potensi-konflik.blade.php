<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Potensi Konflik - {{ $record->nama_potensi }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 10px; }
        .section { margin-bottom: 20px; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <h1>{{ $record->nama_potensi }}</h1>

    <div class="section">
        <span class="label">Tanggal Identifikasi:</span> {{ $record->tanggal_potensi->format('d/m/Y') }}
    </div>

    <div class="section">
        <span class="label">Penanggung Jawab:</span> {{ $record->penanggung_jawab ?? '-' }}
    </div>

    <div class="section">
        <span class="label">Lokasi:</span>
        @if ($record->desa)
            {{ $record->desa->nama }},
            Kecamatan {{ $record->desa->kecamatan->nama }},
            {{ $record->desa->kecamatan->kabupaten->nama }}
        @else
            -
        @endif
    </div>

    <div class="section">
        <span class="label">Latar Belakang:</span><br>
        {!! $record->latar_belakang !!}
    </div>
</body>
</html>
