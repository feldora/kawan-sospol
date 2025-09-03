@extends('layouts.landingpage', [
    'title' => 'Dashboard - Kesbangpol Sulteng',
    'showHeader' => true,
    'headerTitle' => 'Dashboard Kesbangpol Sulteng',
    'headerSubtitle' => 'Sistem Monitoring Potensi Konflik',
])

@section('content')
    <div class="container px-4 py-6 mx-auto lg:px-6">
        <!-- Peta Utama + Footer Tabel -->
        <div class="relative flex flex-col mb-6 overflow-hidden bg-white shadow-lg rounded-2xl">
            <div
                class="flex flex-col items-start justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-teal-50 sm:flex-row sm:items-center">
                <div>
                    <h1 class="flex items-center mb-2 text-3xl font-bold text-gray-800">
                        <svg class="w-8 h-8 mr-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3">
                            </path>
                        </svg>
                        Peta Potensi Konflik Interaktif
                    </h1>
                    <p class="text-gray-600">Klik pada area untuk melihat detail potensi konflik. Gunakan filter untuk
                        menyaring data sesuai kebutuhan.</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <button id="fullscreen-btn"
                        class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-teal-600 rounded-lg hover:bg-teal-700">
                        <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                            </path>
                        </svg>
                        Layar Penuh
                    </button>
                </div>
            </div>

            <div id="map" class="w-full h-[70vh] lg:h-[80vh]"></div>
            <div id="map-loading" class="absolute inset-0 z-10 flex items-center justify-center bg-gray-100">
                <div class="text-center">
                    <div class="w-12 h-12 mx-auto mb-4 border-b-2 border-teal-600 rounded-full animate-spin"></div>
                    <p class="text-gray-600">Memuat peta dan data potensi konflik...</p>
                </div>
            </div>

            <!-- Footer Tabel dalam Card -->
            <div id="map-footer"
                class="w-full p-4 m-4 overflow-x-auto bg-white border border-gray-200 shadow-lg rounded-2xl max-h-100">
                <h3 class="mb-2 text-lg font-bold text-gray-800">Daftar Potensi Konflik</h3>
                <table class="w-full text-sm border border-collapse">
                    <thead class="bg-gray-100 ">
                        <tr>
                            <th class="px-3 py-2 border">Nama Potensi</th>
                            <th class="px-3 py-2 border">Lokasi</th>
                            <th class="px-3 py-2 border">Tanggal</th>
                            <th class="px-3 py-2 border">Penanggung Jawab</th>
                            <th class="px-3 py-2 border">Latar Belakang</th>
                        </tr>
                    </thead>
                    <tbody id="map-footer-body">
                        <tr>
                            <td colspan="5" class="py-4 text-center text-gray-500">Klik pada area untuk melihat daftar
                                potensi konflik.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <style>
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .leaflet-popup-content {
            margin: 16px;
            line-height: 1.6;
        }

        .leaflet-popup-tip {
            box-shadow: 0 3px 14px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const defaultView = {
                // center: [-0.900, 119.870],
                center: [-1.2, 121.0],
                zoom: 7
            };
            var map = L.map('map').setView(defaultView.center, defaultView.zoom);
            // var map = L.map('map');
            const bounds = [
                [-1.8, 119.0], // barat daya
                [1.0, 123.0] // timur laut
            ];

            // Fit map ke seluruh Sulawesi Tengah
            map.fitBounds(bounds);


            setTimeout(() => {
                document.getElementById('map-loading').style.display = 'none';
            }, 1000);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 18,
            }).addTo(map);

            const potensiIcon = L.divIcon({
                html: '<div class="flex items-center justify-center w-6 h-6 bg-green-500 border-2 border-white rounded-full shadow-lg"><svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M10 0a10 10 0 110 20 10 10 0 010-20z"></path></svg></div>',
                className: 'custom-marker-potensi',
                iconSize: [24, 24],
                iconAnchor: [12, 12]
            });

            const fsBtn = document.getElementById('fullscreen-btn');
            fsBtn.addEventListener('click', function() {
                const mapContainer = document.getElementById('map').parentElement;
                if (!document.fullscreenElement) {
                    mapContainer.requestFullscreen().then(() => {
                        fsBtn.textContent = 'Keluar Layar Penuh';
                        setTimeout(() => map.invalidateSize(), 100);
                    });
                } else {
                    document.exitFullscreen().then(() => {
                        fsBtn.textContent = 'Layar Penuh';
                        setTimeout(() => map.invalidateSize(), 100);
                    });
                }
            });

            let activeLayer = null; // Simpan layer aktif untuk zoom

            fetch("{{ url('/api/data/potensiKonflik') }}")
                .then(response => response.json())
                .then(res => {
                    const counts = {};
                    res.data.forEach(item => {
                        const key = item.lokasi;
                        if (!counts[key]) counts[key] = 0;
                        counts[key]++;
                    });

                    res.data.forEach(item => {
                        if (item.geojson) {
                            const geoLayer = L.geoJSON(item.geojson, {
                                onEachFeature: function(feature, layer) {
                                    const lokasi = item.lokasi;
                                    const jumlah = counts[lokasi] || 1;

                                    layer.bindPopup(`
                                <div class="p-3 font-bold text-center text-gray-800">
                                    ${lokasi} <br>
                                    <span class="text-teal-600">${jumlah} Potensi Konflik</span>
                                </div>
                            `, {
                                        maxWidth: 200
                                    });

                                    layer.on("click", function(e) {
                                        const daftar = res.data.filter(d => d
                                            .lokasi === lokasi);
                                        let rows = '';
                                        daftar.forEach(d => {
                                            rows += `
                                        <tr>
                                            <td class="px-3 py-2 font-bold border">${d.nama_potensi}</td>
                                            <td class="px-3 py-2 border">${d.lokasi}</td>
                                            <td class="px-3 py-2 border">${d.tanggal_potensi}</td>
                                            <td class="px-3 py-2 border">${d.penanggung_jawab}</td>
                                            <td class="px-3 py-2 border">${d.latar_belakang}</td>
                                        </tr>
                                    `;
                                        });
                                        document.getElementById("map-footer-body")
                                            .innerHTML = rows;

                                        // Zoom in ke layer yang diklik
                                        // map.fitBounds(layer.getBounds(), { maxZoom: 14, padding: [50, 50] });
                                        map.flyToBounds(layer.getBounds(), {
                                            maxZoom: 14,
                                            padding: [50, 50],
                                            duration: 1.2 // detik
                                        });


                                        activeLayer = layer;
                                    });
                                },
                                pointToLayer: function(feature, latlng) {
                                    return L.marker(latlng, {
                                        icon: potensiIcon
                                    });
                                },
                                style: {
                                    color: "#b93210",
                                    weight: 2,
                                    fillOpacity: 0.5,
                                    fillColor: "#b93210"
                                }
                            }).addTo(map);
                        }
                    });

                    // Zoom out ketika klik di map tapi bukan di layer
                    map.on('click', function(e) {
                        if (!activeLayer) return;
                        // map.setView(defaultView.center, defaultView.zoom);
                        map.flyTo(defaultView.center, defaultView.zoom, {
                            animate: true,
                            duration: 1.2 // makin besar makin lambat (detik)
                        });
                        activeLayer = null;
                        // Reset tabel footer
                        document.getElementById("map-footer-body").innerHTML = `
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">Klik pada area untuk melihat daftar potensi konflik.</td>
                    </tr>
                `;
                    });
                })
                .catch(err => console.error("Gagal load data potensi konflik:", err));
        });
    </script>
@endpush
