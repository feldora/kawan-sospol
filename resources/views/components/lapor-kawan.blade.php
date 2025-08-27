
    <div class="w-full mx-auto">
        <!-- Form Pelaporan -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-orange-50 to-red-50 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Form Pelaporan Konflik
                </h2>
                <p class="text-gray-600 mt-2">Laporkan kejadian konflik sosial atau politik di wilayah Anda</p>
            </div>

            <!-- Progress Indicator -->
            <div class="p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="progress-step active w-10 h-10 rounded-full border-2 border-blue-600 bg-blue-600 text-white flex items-center justify-center text-sm font-semibold">1</div>
                        <div class="progress-step w-10 h-10 rounded-full border-2 border-gray-300 bg-gray-100 text-gray-500 flex items-center justify-center text-sm font-semibold">2</div>
                        <div class="progress-step w-10 h-10 rounded-full border-2 border-gray-300 bg-gray-100 text-gray-500 flex items-center justify-center text-sm font-semibold">3</div>
                    </div>
                    <div class="text-sm text-gray-600">
                        <span id="stepText">Langkah 1 dari 3: Data Pelapor</span>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 33%"></div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="p-8">
                <form id="konfliktForm" method="POST" action="/laporan/store" class="space-y-6">
                    @csrf

                    <!-- Step 1: Data Pelapor & Lokasi -->
                    <div class="step active" id="step1">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Data Pelapor</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Nama Pelapor <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_pelapor" id="nama_pelapor" class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Kontak (HP/Email) <span class="text-red-500">*</span></label>
                                <input type="text" name="kontak" id="kontak" class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500" required>
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="mt-6 space-y-4">
                            <h4 class="text-md font-semibold text-gray-800">Lokasi Kejadian</h4>
                            <x-select-wilayah :kabupatenId="old('kabupaten_id')" :kecamatanId="old('kecamatan_id')" :desaId="old('desa_id')" />

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Atau Lokasi Manual</label>
                                <textarea name="lokasi_text" id="lokasi_text" class="w-full border rounded-lg px-4 py-3" rows="2"></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-sm">Latitude</label>
                                    <input type="number" name="lat" id="lat" step="0.0000001" class="w-full border rounded-lg px-4 py-3">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm">Longitude</label>
                                    <input type="number" name="lng" id="lng" step="0.0000001" class="w-full border rounded-lg px-4 py-3">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
                                    <button type="button" id="getCurrentLocation"
                                            class="w-full bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition-colors">
                                        📍 Ambil Lokasi Saat Ini
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Detail Konflik -->
                    <div class="step" id="step2">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Detail Konflik</h3>
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Deskripsi Konflik <span class="text-red-500">*</span></label>
                                <textarea name="deskripsi" id="deskripsi" class="w-full border rounded-lg px-4 py-3" rows="5" required></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Tindak Lanjut -->
                    <div class="step" id="step3">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6">Tindak Lanjut</h3>
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Diteruskan Ke</label>
                                <select name="diteruskan_ke" class="w-full border rounded-lg px-4 py-3">
                                    <option value="">Pilih Instansi</option>
                                    <option value="Kepolisian">Kepolisian</option>
                                    <option value="TNI">TNI</option>
                                    <option value="Pemerintah Desa">Pemerintah Desa</option>
                                    <option value="Camat">Camat</option>
                                    <option value="Bupati">Bupati</option>
                                    <option value="Gubernur">Gubernur</option>
                                </select>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-800 mb-3">Review Data Laporan</h4>
                                <div id="reviewData" class="space-y-2 text-sm text-gray-600"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="flex justify-between pt-6 border-t">
                        <button type="button" id="prevBtn" class="px-6 py-3 bg-gray-300 rounded-lg" style="display: none;">← Sebelumnya</button>
                        <div class="flex space-x-4">
                            <button type="button" id="nextBtn" class="px-8 py-3 bg-blue-600 text-white rounded-lg">Selanjutnya →</button>
                            <button type="submit" id="submitBtn" class="px-8 py-3 bg-green-600 text-white rounded-lg" style="display: none;">Kirim Laporan</button>
                        </div>
                    </div>

                    <input type="hidden" name="status" value="baru">
                </form>
            </div>
        </div>
    </div>

@push('styles')
<style>
.step { display: none; }
.step.active { display: block; }
.progress-step.active { background-color: #3B82F6; color: white; }
.progress-step.completed { background-color: #10B981; color: white; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1, totalSteps = 3;

        // Get current location
        document.getElementById('getCurrentLocation').addEventListener('click', function() {
            if (navigator.geolocation) {
                this.textContent = '📍 Mengambil lokasi...';
                this.disabled = true;

                navigator.geolocation.getCurrentPosition((position) => {
                    document.getElementById('lat').value = position.coords.latitude.toFixed(7);
                    document.getElementById('lng').value = position.coords.longitude.toFixed(7);
                    this.textContent = '✅ Lokasi berhasil diambil';
                    setTimeout(() => {
                        this.textContent = '📍 Ambil Lokasi Saat Ini';
                        this.disabled = false;
                    }, 2000);
                }, (error) => {
                    alert('Gagal mengambil lokasi: ' + error.message);
                    this.textContent = '📍 Ambil Lokasi Saat Ini';
                    this.disabled = false;
                });
            } else {
                alert('Browser tidak mendukung geolocation');
            }
        });

    function showStep(step) {
        document.querySelectorAll('.step').forEach(s => s.classList.remove('active'));
        document.getElementById('step' + step).classList.add('active');

        document.querySelectorAll('.progress-step').forEach((s, i) => {
            s.classList.remove('active','completed');
            if (i+1 < step) s.classList.add('completed');
            if (i+1 === step) s.classList.add('active');
        });

        document.getElementById('progressBar').style.width = (step * 33.33) + '%';
        document.getElementById('stepText').textContent = [
            'Langkah 1 dari 3: Data Pelapor',
            'Langkah 2 dari 3: Detail Konflik',
            'Langkah 3 dari 3: Tindak Lanjut'
        ][step-1];

        document.getElementById('prevBtn').style.display = step === 1 ? 'none' : 'block';
        document.getElementById('nextBtn').style.display = step === totalSteps ? 'none' : 'block';
        document.getElementById('submitBtn').style.display = step === totalSteps ? 'block' : 'none';
    }

    function validateStep(step) {
        if (step === 1) {
            if (!document.getElementById('nama_pelapor').value) return alert('Nama harus diisi'), false;
            if (!document.getElementById('kontak').value) return alert('Kontak harus diisi'), false;
        }
        if (step === 2) {
            if (!document.getElementById('deskripsi').value || document.getElementById('deskripsi').value.length < 20)
                return alert('Deskripsi minimal 20 karakter'), false;
        }
        return true;
    }

    document.getElementById('nextBtn').addEventListener('click', () => {
        if (validateStep(currentStep)) {
            if (currentStep === 2) {
                document.getElementById('reviewData').innerHTML =
                    `<div><b>Nama:</b> ${document.getElementById('nama_pelapor').value}</div>
                     <div><b>Kontak:</b> ${document.getElementById('kontak').value}</div>
                     <div><b>Deskripsi:</b> ${document.getElementById('deskripsi').value}</div>`;
            }
            currentStep++;
            showStep(currentStep);
        }
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
        currentStep--; showStep(currentStep);
    });

    showStep(1);
});
</script>
@endpush
