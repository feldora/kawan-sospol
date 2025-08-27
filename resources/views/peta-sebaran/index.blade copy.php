@extends('layouts.landingpage', [
    'title' => 'Peta Konflik - Kesbangpol Sulteng',
    'showHeader' => true,
    'headerTitle' => 'Peta Konflik di Sulawesi Tengah',
    'headerSubtitle' => 'Visualisasi Geografis Konflik Sosial & Politik'
])

@section('content')
<div class="container mx-auto py-6 px-4 lg:px-6">
    <!-- Filter dan Kontrol Peta -->
    <div class="mb-6">
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
            <div class="flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
                <div class="flex flex-col sm:flex-row gap-4 flex-1">
                    <!-- Filter Jenis Konflik -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-gray-700 mb-2">Filter Jenis Konflik</label>
                        <div class="flex gap-2">
                            <button id="filter-all" class="filter-btn active px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                                <span class="w-3 h-3 bg-gray-400 rounded-full inline-block mr-2"></span>
                                Semua
                            </button>
                            <button id="filter-sosial" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                                <span class="w-3 h-3 bg-red-500 rounded-full inline-block mr-2"></span>
                                Sosial
                            </button>
                            <button id="filter-politik" class="filter-btn px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                                <span class="w-3 h-3 bg-blue-500 rounded-full inline-block mr-2"></span>
                                Politik
                            </button>
                        </div>
                    </div>

                    <!-- Filter Kabupaten -->
                    <div class="flex flex-col">
                        <label for="filter-kabupaten" class="text-sm font-medium text-gray-700 mb-2">Filter Kabupaten</label>
                        <select id="filter-kabupaten" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="">Semua Kabupaten</option>
                            <!-- Options akan diisi via JavaScript -->
                        </select>
                    </div>
                </div>

                <!-- Info dan Kontrol -->
                <div class="flex flex-col sm:flex-row gap-2">
                    <button id="reset-view" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset View
                    </button>
                    <div class="px-4 py-2 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium">
                        <span id="conflict-counter">0</span> Konflik Ditampilkan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peta Utama -->
    <div class="mb-6">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 flex items-center mb-2">
                            <svg class="w-8 h-8 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m-6 3l6-3"></path>
                            </svg>
                            Peta Konflik Interaktif
                        </h1>
                        <p class="text-gray-600">Klik pada marker untuk melihat detail konflik. Gunakan filter untuk menyaring data sesuai kebutuhan.</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <button id="fullscreen-btn" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors duration-200">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Legenda Peta
            </h3>
            <div class="space-y-3">
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-red-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center mr-3">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Konflik Sosial</p>
                        <p class="text-sm text-gray-600">Konflik yang melibatkan masyarakat</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-6 h-6 bg-blue-500 rounded-full border-2 border-white shadow-lg flex items-center justify-center mr-3">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Statistik Peta
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="text-center p-4 bg-red-50 rounded-lg border border-red-200">
                    <p class="text-3xl font-bold text-red-600" id="map-stat-sosial">0</p>
                    <p class="text-sm font-medium text-red-500">Konflik Sosial</p>
                </div>
                <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-3xl font-bold text-blue-600" id="map-stat-politik">0</p>
                    <p class="text-sm font-medium text-blue-500">Konflik Politik</p>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-3xl font-bold text-gray-800" id="map-stat-total">0</p>
                    <p class="text-sm font-medium text-gray-500">Total Konflik</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Konflik -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-blue-50">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                Daftar Konflik Terdaftar
            </h3>
            <p class="text-gray-600 mt-1">Data konflik yang ditampilkan di peta</p>
        </div>
        <div class="p-6">
            <div id="conflict-list" class="space-y-4">
                <!-- Loading state -->
                <div class="animate-pulse space-y-4">
                    <div class="flex p-4 bg-gray-100 rounded-lg">
                        <div class="w-4 h-4 bg-gray-300 rounded-full mr-4 mt-1"></div>
                        <div class="flex-1 space-y-2">
                            <div class="h-4 bg-gray-300 rounded w-3/4"></div>
                            <div class="h-3 bg-gray-300 rounded w-1/2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Filter buttons styling */
.filter-btn {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #64748b;
}

.filter-btn.active {
    background: #3b82f6;
    border-color: #3b82f6;
    color: white;
}

.filter-btn:hover:not(.active) {
    background: #f1f5f9;
    border-color: #cbd5e1;
}

/* Leaflet popup custom styling */
.leaflet-popup-content-wrapper {
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    max-width: 350px;
}

.leaflet-popup-content {
    margin: 20px;
    line-height: 1.6;
    font-size: 14px;
}

.leaflet-popup-tip {
    box-shadow: 0 3px 14px rgba(0, 0, 0, 0.1);
}

/* Custom marker animations */
.custom-marker-social, .custom-marker-political {
    animation: markerBounce 1s ease-in-out;
}

@keyframes markerBounce {
    0% {
        transform: translateY(-10px) scale(0);
        opacity: 0;
    }
    50% {
        transform: translateY(0) scale(1.1);
        opacity: 0.8;
    }
    100% {
        transform: translateY(0) scale(1);
        opacity: 1;
    }
}

/* Fullscreen styles */
.fullscreen-map {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    z-index: 9999 !important;
}

/* Conflict list item hover effect */
.conflict-item {
    transition: all 0.2s ease;
}

.conflict-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize map
    const map = L.map('map').setView([-0.900, 119.870], 9);
    const originalView = [-0.900, 119.870];
    const originalZoom = 9;

    // Variables to store map data
    let allConflicts = [];
    let filteredConflicts = [];
    let markerLayer = L.layerGroup().addTo(map);
    let currentFilter = 'all';
    let currentKabupaten = '';

    // Hide loading indicator after a delay
    setTimeout(() => {
        document.getElementById('map-loading').style.display = 'none';
    }, 1000);

    // Add tile layer
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

    // Fetch conflict data
    function loadConflictData() {
        fetch("{{ route('api.data.konflik') }}")
            .then(response => response.json())
            .then(res => {
                allConflicts = res.data;

                // Populate kabupaten dropdown
                const kabupatenSet = new Set();
                allConflicts.forEach(item => {
                    if (item.lokasi) {
                        kabupatenSet.add(item.lokasi);
                    }
                });

                const kabupatenSelect = document.getElementById('filter-kabupaten');
                Array.from(kabupatenSet).sort().forEach(kabupaten => {
                    const option = document.createElement('option');
                    option.value = kabupaten;
                    option.textContent = kabupaten;
                    kabupatenSelect.appendChild(option);
                });

                // Initial display
                applyFilters();
            })
            .catch(error => {
                console.error('Gagal load data konflik:', error);
                document.getElementById('conflict-list').innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>Gagal memuat data konflik</p>
                    </div>
                `;
            });
    }

    // Apply filters and update display
    function applyFilters() {
        filteredConflicts = allConflicts.filter(item => {
            const typeMatch = currentFilter === 'all' ||
                             (currentFilter === 'sosial' && item.jenis === 'Konflik Sosial') ||
                             (currentFilter === 'politik' && item.jenis === 'Konflik Politik');

            const locationMatch = !currentKabupaten || item.lokasi === currentKabupaten;

            return typeMatch && locationMatch;
        });

        updateMapDisplay();
        updateStatistics();
        updateConflictList();
        updateCounter();
    }

    // Update map markers
    function updateMapDisplay() {
        markerLayer.clearLayers();

        filteredConflicts.forEach(function(item) {
            if (item.geojson) {
                const isSocket = item.jenis === "Konflik Sosial";
                const icon = isSocket ? socialConflictIcon : politicalConflictIcon;

                L.geoJSON(item.geojson, {
                    onEachFeature: function (feature, layer) {
                        const popupContent = `
                            <div class="p-2">
                                <div class="flex items-center mb-3">
                                    <span class="inline-block w-4 h-4 rounded-full ${isSocket ? 'bg-red-500' : 'bg-blue-500'} mr-3"></span>
                                    <strong class="text-lg font-semibold">${item.jenis}</strong>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div class="bg-gray-50 p-2 rounded">
                                        <p class="font-medium text-gray-700">Lokasi:</p>
                                        <p class="text-gray-600">${item.lokasi}</p>
                                    </div>
                                    <div class="bg-gray-50 p-2 rounded">
                                        <p class="font-medium text-gray-700">Jumlah Kasus:</p>
                                        <p class="font-bold text-xl ${isSocket ? 'text-red-600' : 'text-blue-600'}">${item.jumlah}</p>
                                    </div>
                                    <div class="bg-green-50 p-2 rounded border border-green-200">
                                        <p class="font-medium text-gray-700">Status Penanganan:</p>
                                        <p class="text-green-700 font-medium">${item.penanganan}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        layer.bindPopup(popupContent, {
                            maxWidth: 350,
                            className: 'custom-popup'
                        });
                    },
                    pointToLayer: function (feature, latlng) {
                        return L.marker(latlng, { icon: icon });
                    },
                    style: function(feature) {
                        return {
                            color: isSocket ? "#ef4444" : "#3b82f6",
                            weight: 3,
                            fillOpacity: 0.6,
                            fillColor: isSocket ? "#ef4444" : "#3b82f6"
                        };
                    }
                }).addTo(markerLayer);
            }
        });
    }

    // Update statistics
    function updateStatistics() {
        const socialCount = filteredConflicts.filter(item => item.jenis === 'Konflik Sosial').length;
        const politicalCount = filteredConflicts.filter(item => item.jenis === 'Konflik Politik').length;
        const totalCount = socialCount + politicalCount;

        document.getElementById('map-stat-sosial').textContent = socialCount;
        document.getElementById('map-stat-politik').textContent = politicalCount;
        document.getElementById('map-stat-total').textContent = totalCount;
    }

    // Update conflict list
    function updateConflictList() {
        const listContainer = document.getElementById('conflict-list');

        if (filteredConflicts.length === 0) {
            listContainer.innerHTML = `
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p>Tidak ada data konflik yang sesuai dengan filter</p>
                </div>
            `;
            return;
        }

        listContainer.innerHTML = filteredConflicts.map((item, index) => {
            const isSocket = item.jenis === "Konflik Sosial";
            return `
                <div class="conflict-item flex p-4 border border-gray-200 rounded-lg hover:border-${isSocket ? 'red' : 'blue'}-300" style="animation-delay: ${index * 50}ms">
                    <div class="w-4 h-4 rounded-full ${isSocket ? 'bg-red-500' : 'bg-blue-500'} mr-4 mt-1 flex-shrink-0"></div>
                    <div class="flex-1">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                            <h4 class="font-semibold text-gray-800">${item.jenis}</h4>
                            <span class="text-sm font-bold ${isSocket ? 'text-red-600' : 'text-blue-600'}">${item.jumlah} Kasus</span>
                        </div>
                        <p class="text-gray-600 text-sm mb-1">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            ${item.lokasi}
                        </p>
                        <p class="text-green-600 text-sm font-medium">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            ${item.penanganan}
                        </p>
                    </div>
                </div>
            `;
        }).join('');
    }

    // Update counter
    function updateCounter() {
        document.getElementById('conflict-counter').textContent = filteredConflicts.length;
    }

    // Event listeners for filters
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.id.replace('filter-', '');
            applyFilters();
        });
    });

    document.getElementById('filter-kabupaten').addEventListener('change', function() {
        currentKabupaten = this.value;
        applyFilters();
    });

    // Reset view button
    document.getElementById('reset-view').addEventListener('click', function() {
        map.setView(originalView, originalZoom);
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

    // Initialize data loading
    loadConflictData();

    // Add map click event for coordinates display (optional feature)
    map.on('click', function(e) {
        console.log('Koordinat yang diklik:', e.latlng.lat, e.latlng.lng);
    });

    // Add zoom event to update view info
    map.on('zoomend', function() {
        const zoom = map.getZoom();
        if (zoom > 12) {
            // Show more detailed view message or features
        }
    });

    // Animation for conflict items when they appear
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe conflict items for animation
    function observeConflictItems() {
        const conflictItems = document.querySelectorAll('.conflict-item');
        conflictItems.forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';
            item.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(item);
        });
    }

    // Call observe function after updating conflict list
    const originalUpdateConflictList = updateConflictList;
    updateConflictList = function() {
        originalUpdateConflictList();
        setTimeout(observeConflictItems, 100);
    };

    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // ESC to exit fullscreen
        if (e.key === 'Escape' && document.fullscreenElement) {
            document.exitFullscreen();
        }
        // F to toggle fullscreen
        if (e.key === 'f' || e.key === 'F') {
            if (!document.querySelector('input:focus') && !document.querySelector('select:focus')) {
                e.preventDefault();
                document.getElementById('fullscreen-btn').click();
            }
        }
        // R to reset view
        if (e.key === 'r' || e.key === 'R') {
            if (!document.querySelector('input:focus') && !document.querySelector('select:focus')) {
                e.preventDefault();
                document.getElementById('reset-view').click();
            }
        }
    });

    // Add tooltip functionality
    function addTooltips() {
        const tooltipElements = [
            { id: 'reset-view', text: 'Reset tampilan peta (Shortcut: R)' },
            { id: 'fullscreen-btn', text: 'Mode layar penuh (Shortcut: F)' },
        ];

        tooltipElements.forEach(item => {
            const element = document.getElementById(item.id);
            if (element) {
                element.title = item.text;
            }
        });
    }

    // Initialize tooltips
    addTooltips();

    // Add responsive behavior for mobile
    function handleResize() {
        if (window.innerWidth < 768) {
            // Mobile adjustments
            map.setView(originalView, Math.max(originalZoom - 1, 7));
        }
    }

    window.addEventListener('resize', handleResize);

    // Initial resize check
    handleResize();
});
</script>
@endpush
