@extends('layouts.landingpage', [
    'title' => 'Dashboard - Kesbangpol Sulteng',
    'showHeader' => true,
    'headerTitle' => 'Dashboard Kesbangpol Sulteng',
    'headerSubtitle' => 'Sistem Monitoring Konflik Sosial & Politik'
])

@section('content')
<div class="container mx-auto py-6 px-4 lg:px-6">
    <!-- Statistik Ringkasan -->
    <div class="mb-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            Statistik Ringkasan
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="statistik">
            <div class="group p-8 bg-gradient-to-br from-red-50 to-red-100 border border-red-200 shadow-lg rounded-2xl text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-500 text-white rounded-full mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-700 mb-2">Konflik Sosial</h3>
                <p class="text-4xl font-extrabold text-red-600 mb-2" id="stat-sosial">
                    <span class="loading-animation">...</span>
                </p>
                <p class="text-sm text-red-500 font-medium">Kasus Terdaftar</p>
            </div>

            <div class="group p-8 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 shadow-lg rounded-2xl text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-500 text-white rounded-full mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-700 mb-2">Konflik Politik</h3>
                <p class="text-4xl font-extrabold text-blue-600 mb-2" id="stat-politik">
                    <span class="loading-animation">...</span>
                </p>
                <p class="text-sm text-blue-500 font-medium">Kasus Terdaftar</p>
            </div>

            <div class="group p-8 bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 shadow-lg rounded-2xl text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-600 text-white rounded-full mb-4 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-700 mb-2">Total Konflik</h3>
                <p class="text-4xl font-extrabold text-gray-800 mb-2" id="stat-total">
                    <span class="loading-animation">...</span>
                </p>
                <p class="text-sm text-gray-500 font-medium">Total Kasus</p>
            </div>
        </div>
    </div>

    <!-- Statistik Per Kabupaten -->
    <div class="mb-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Statistik Per Kabupaten
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="statistik-kabupaten">
            <!-- Loading skeleton -->
            <div class="animate-pulse p-6 bg-gray-200 rounded-2xl">
                <div class="h-4 bg-gray-300 rounded w-3/4 mb-3"></div>
                <div class="h-3 bg-gray-300 rounded w-1/2 mb-2"></div>
                <div class="h-3 bg-gray-300 rounded w-1/2 mb-2"></div>
                <div class="h-3 bg-gray-300 rounded w-1/2"></div>
            </div>
            <!-- Card kabupaten akan dimasukkan lewat JS -->
        </div>
    </div>

    <!-- Peta Interaktif -->
    <div class="mb-10">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3"></path>
                    </svg>
                    Peta Konflik di Sulawesi Tengah
                </h2>
                <p class="text-gray-600 mt-2">Klik pada marker untuk melihat detail konflik</p>
            </div>
            <div class="relative">
                <div id="map" class="w-full h-96 lg:h-[500px]"></div>
                <div id="map-loading" class="absolute inset-0 bg-gray-100 flex items-center justify-center">
                    <div class="text-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                        <p class="text-gray-600">Memuat peta...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Pelaporan -->
    <x-lapor-kawan />
</div>

<style>
.loading-animation {
    display: inline-block;
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out forwards;
}

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

.step {
    display: none;
}

.step.active {
    display: block;
}

.progress-step.active {
    background-color: #3B82F6;
    color: white;
}

.progress-step.completed {
    background-color: #10B981;
    color: white;
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

    // Custom icons for different conflict types
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

    // Fetch data konflik dari API
            fetch("{{ url('api/data/konflik-kabupaten') }}")
                .then(response => response.json())
                .then(res => {
                    let container = document.getElementById("statistik-kabupaten");
                    container.innerHTML = '';

                    // Kelompokkan data per kabupaten (karena API memberikan data per desa)
                    const dataKabupaten = {};
                    let totalSosial = 0;
                    let totalPolitik = 0;

                    // Group data by kabupaten
                    res.data.forEach(item => {
                        const kabupaten = item.kabupaten || 'Tidak Diketahui';

                        if (!dataKabupaten[kabupaten]) {
                            dataKabupaten[kabupaten] = {
                                kabupaten: kabupaten,
                                konflik_sosial: 0,
                                konflik_politik: 0,
                                total_konflik: 0,
                                desa_list: [],
                                kabupaten,
                            };
                        }

                        // Akumulasi jumlah konflik per kabupaten
                        const sosial = parseInt(item.konflik_sosial) || 0;
                        const politik = parseInt(item.konflik_politik) || 0;

                        dataKabupaten[kabupaten].konflik_sosial += sosial;
                        dataKabupaten[kabupaten].konflik_politik += politik;
                        dataKabupaten[kabupaten].total_konflik += sosial + politik;
                        dataKabupaten[kabupaten].desa_list.push({
                            desa: item.desa || item.kecamatan || '-',
                            sosial: sosial,
                            politik: politik,
                        });

                        // Hitung total keseluruhan
                        totalSosial += sosial;
                        totalPolitik += politik;
                    });

                    // Buat card untuk setiap kabupaten
                    Object.values(dataKabupaten).forEach((kabupatenData, index) => {
                        // Buat card per kabupaten
                        let card = document.createElement("div");
                        card.className = "group p-6 bg-white border border-gray-200 shadow-lg rounded-2xl hover:shadow-xl transition-all duration-300 hover:-translate-y-1 opacity-0";
                        card.style.animationDelay = `${index * 100}ms`;

                        card.innerHTML = `
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-bold text-gray-800">${kabupatenData.kabupaten}</h3>
                                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                    ${kabupatenData.total_konflik}
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center text-sm font-medium text-gray-600">
                                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                        Sosial
                                    </span>
                                    <span class="font-bold text-red-600">${kabupatenData.konflik_sosial}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="flex items-center text-sm font-medium text-gray-600">
                                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                                        Politik
                                    </span>
                                    <span class="font-bold text-blue-600">${kabupatenData.konflik_politik}</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-2">
                                    ${kabupatenData.desa_list.length} Desa/Kecamatan
                                </div>
                            </div>
                        `;

                        container.appendChild(card);

                        setTimeout(() => {
                            card.classList.remove('opacity-0');
                            card.classList.add('animate-fade-in');
                        }, index * 100);
                    });

                    res.data.forEach(function(item) {
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

    // Form functionality (existing code)
    let currentStep = 1;
    const totalSteps = 3;

    // Form submission
    document.getElementById('konfliktForm').addEventListener('submit', function(e) {
        e.preventDefault();

        if (validateStep(3)) {
            // Here you would normally submit the form
            alert('Form akan dikirim ke server. Implementasi sesuai dengan Laravel route.');
            // this.submit(); // Uncomment for actual submission
        }
    });
});
</script>
@endpush
