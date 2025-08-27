@extends('layouts.landingpage', [
    'title' => 'Dashboard - Kesbangpol Sulteng',
    'showHeader' => true,
    'headerTitle' => 'Dashboard Kesbangpol Sulteng',
    'headerSubtitle' => 'Sistem Monitoring Konflik Sosial & Politik',
])

@section('content')
    <div class="container mx-auto py-6 px-4 lg:px-6">
        <!-- Peta Utama -->
        <div class="mb-6">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 flex items-center mb-2">
                                <svg class="w-8 h-8 mr-3 text-indigo-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3">
                                    </path>
                                </svg>
                                Peta Konflik Interaktif
                            </h1>
                            <p class="text-gray-600">Klik pada marker untuk melihat detail konflik. Gunakan filter untuk
                                menyaring data sesuai kebutuhan.</p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <button id="fullscreen-btn"
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors duration-200">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                                    </path>
                                </svg>
                                Layar Penuh
                            </button>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div id="map" class="w-full h-[70vh] lg:h-[80vh]"></div>
                    <div id="map-loading" class="absolute inset-0 bg-gray-100 flex items-center justify-center">
                        <div class="text-center">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                            <p class="text-gray-600">Memuat peta dan data konflik...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Legenda dan Statistik -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Legenda -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Legenda Peta
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div
                            class="w-6 h-6 bg-red-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center mr-3">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Konflik Sosial</p>
                            <p class="text-sm text-gray-600">Konflik yang melibatkan masyarakat</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div
                            class="w-6 h-6 bg-blue-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center mr-3">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Konflik Politik</p>
                            <p class="text-sm text-gray-600">Konflik yang berkaitan dengan politik</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Real-time -->
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    Statistik Peta
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-red-50 rounded-lg border border-red-200">
                        <p class="text-3xl font-bold text-red-600" id="stat-sosial">0</p>
                        <p class="text-sm font-medium text-red-500">Konflik Sosial</p>
                    </div>
                    <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-3xl font-bold text-blue-600" id="stat-politik">0</p>
                        <p class="text-sm font-medium text-blue-500">Konflik Politik</p>
                    </div>
                    <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-3xl font-bold text-gray-800" id="stat-total">0</p>
                        <p class="text-sm font-medium text-gray-500">Total Konflik</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- Detail Konflik Desa -->
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200 mt-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Detail Konflik</h3>
            <div id="desa-detail-container">
                <p class="text-gray-500">Klik pada area untuk melihat detail konflik.</p>
            </div>
        </div>

    </div>

    <style>
        /* Leaflet popup custom styling */
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
            // Initialize map
            var map = L.map('map').setView([-0.900, 119.870], 9);

            // Hide loading indicator
            setTimeout(() => {
                document.getElementById('map-loading').style.display = 'none';
            }, 1000);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 18,
            }).addTo(map);

            // Custom icons
            const socialConflictIcon = L.divIcon({
                html: '<div class="w-6 h-6 bg-red-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center"><svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg></div>',
                className: 'custom-marker-social',
                iconSize: [24, 24],
                iconAnchor: [12, 12]
            });

            const politicalConflictIcon = L.divIcon({
                html: '<div class="w-6 h-6 bg-blue-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center"><svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path></svg></div>',
                className: 'custom-marker-political',
                iconSize: [24, 24],
                iconAnchor: [12, 12]
            });

            // Fullscreen functionality
            document.getElementById('fullscreen-btn').addEventListener('click', function() {
                const mapContainer = document.getElementById('map').parentElement.parentElement;
                const btn = this;

                if (!document.fullscreenElement) {
                    mapContainer.requestFullscreen().then(() => {
                        mapContainer.classList.add('fullscreen-map');
                        btn.innerHTML = `
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Keluar Layar Penuh
                `;
                        setTimeout(() => map.invalidateSize(), 100);
                    });
                } else {
                    document.exitFullscreen().then(() => {
                        mapContainer.classList.remove('fullscreen-map');
                        btn.innerHTML = `
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                    </svg>
                    Layar Penuh
                `;
                        setTimeout(() => map.invalidateSize(), 100);
                    });
                }
            });

            // Handle fullscreen change event
            document.addEventListener('fullscreenchange', function() {
                if (!document.fullscreenElement) {
                    const mapContainer = document.querySelector('.fullscreen-map');
                    const btn = document.getElementById('fullscreen-btn');
                    if (mapContainer) {
                        mapContainer.classList.remove('fullscreen-map');
                        btn.innerHTML = `
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                    </svg>
                    Layar Penuh
                `;
                        setTimeout(() => map.invalidateSize(), 100);
                    }
                }
            });

            // Load conflict data (langsung dari konflik-kabupaten)
            fetch("{{ url('api/data/konflik-kabupaten') }}")
                .then(response => response.json())
                .then(res => {
                    // Hitung total untuk statistik
                    let totalSosial = 0;
                    let totalPolitik = 0;

                    res.data.forEach(function(item) {
                        totalSosial += parseInt(item.konflik_sosial) || 0;
                        totalPolitik += parseInt(item.konflik_politik) || 0;

                        if (item.geojson) {
                            // Tentukan warna/ikon berdasarkan mayoritas konflik
                            const isSosial = (item.konflik_sosial >= item.konflik_politik);
                            const icon = isSosial ? socialConflictIcon : politicalConflictIcon;

                            L.geoJSON(item.geojson, {
                                onEachFeature: function(feature, layer) {
                                    const popupContent = `
                                    <div class="p-3 max-w-xs">
                                        <div class="font-bold text-lg mb-2 text-gray-800 border-b pb-1">
                                        ${item.kabupaten}
                                        </div>
                                        <div class="space-y-1 text-sm">
                                        <p><span class="font-semibold text-gray-700">Kecamatan:</span> ${item.kecamatan || '-'}</p>
                                        <p><span class="font-semibold text-gray-700">Desa:</span> ${item.desa || '-'}</p>

                                        <div class="flex justify-between gap-4">
                                            <p>
                                            <span class="font-semibold text-red-600">Sosial:</span>
                                            <span class="text-red-700 font-bold">${item.konflik_sosial}</span>
                                            </p>
                                            <p>
                                            <span class="font-semibold text-blue-600">Politik:</span>
                                            <span class="text-blue-700 font-bold">${item.konflik_politik}</span>
                                            </p>
                                        </div>

                                        <p class="pt-1 border-t">
                                            <span class="font-semibold text-gray-900">Total:</span>
                                            <span class="font-extrabold text-gray-800">${item.total_konflik}</span>
                                        </p>
                                        </div>
                                    </div>
                                    `;

                                    layer.bindPopup(popupContent, { maxWidth: 300 });

                                    // Klik layer → tampilkan detail di tabel
                                    layer.on("click", function() {
                                        document.getElementById("desa-detail-container").innerHTML = `
                                            <div class="overflow-x-auto">
                                                <table class="w-full border-collapse border text-sm">
                                                    <thead class="bg-gray-100">
                                                        <tr>
                                                            <th class="border px-3 py-2">Kabupaten</th>
                                                            <th class="border px-3 py-2">Kecamatan</th>
                                                            <th class="border px-3 py-2">Keluarahan / Desa</th>
                                                            <th class="border px-3 py-2">Konflik Sosial</th>
                                                            <th class="border px-3 py-2">Konflik Politik</th>
                                                            <th class="border px-3 py-2">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="border px-3 py-2">${item.kabupaten}</td>
                                                            <td class="border px-3 py-2">${item.kecamatan || '-'}</td>
                                                            <td class="border px-3 py-2">${item.desa || '-'}</td>
                                                            <td class="border px-3 py-2 text-red-600 font-bold">${item.konflik_sosial}</td>
                                                            <td class="border px-3 py-2 text-blue-600 font-bold">${item.konflik_politik}</td>
                                                            <td class="border px-3 py-2 font-bold">${item.total_konflik}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        `;
                                    });
                                },
                                pointToLayer: function(feature, latlng) {
                                    return L.marker(latlng, { icon: icon });
                                },
                                style: function(feature) {
                                    return {
                                        color: isSosial ? "#ef4444" : "#3b82f6",
                                        weight: 2,
                                        fillOpacity: 0.5,
                                        fillColor: isSosial ? "#ef4444" : "#3b82f6"
                                    };
                                }
                            }).addTo(map);
                        }
                    });

                    // Update Statistik Ringkasan
                    const total = totalSosial + totalPolitik;
                    animateValue("stat-sosial", 0, totalSosial, 1500);
                    animateValue("stat-politik", 0, totalPolitik, 1500);
                    animateValue("stat-total", 0, total, 1500);
                })
                .catch(error => {
                    console.error('Gagal load data konflik kabupaten:', error);
                });

            // Animation function for numbers
            function animateValue(elementId, start, end, duration) {
                const element = document.getElementById(elementId);
                if (!element || end === 0) {
                    if (element) element.textContent = end;
                    return;
                }

                const startTime = performance.now();
                const startValue = start;
                const endValue = end;

                function updateValue(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);

                    // Easing function for smooth animation
                    const easeProgress = 1 - Math.pow(1 - progress, 3);
                    const currentValue = Math.round(startValue + (endValue - startValue) * easeProgress);

                    element.textContent = currentValue;

                    if (progress < 1) {
                        requestAnimationFrame(updateValue);
                    } else {
                        element.textContent = endValue; // Ensure final value is exact
                    }
                }

                requestAnimationFrame(updateValue);
            }

        });
    </script>
@endpush
