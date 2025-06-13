<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cetak Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('reports.generate') }}" method="POST" target="_blank">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="jenis_laporan" class="block font-medium text-sm text-gray-700">Jenis Laporan</label>
                                <select name="jenis_laporan" id="jenis_laporan" class="block mt-1 w-full rounded-md" onchange="toggleReportOptions()">
                                    <option value="bulanan">Laporan Keuangan Bulanan</option>
                                    <option value="semester">Laporan Status SPP Semester</option>
                                </select>
                            </div>

                            <!-- Opsi untuk Laporan Bulanan -->
                            <div id="opsi_bulanan" class="space-y-4">
                                <div>
                                    <label for="bulan" class="block font-medium text-sm text-gray-700">Bulan</label>
                                    <select name="bulan" id="bulan" class="block mt-1 w-full rounded-md">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Opsi untuk Laporan Semester -->
                            <div id="opsi_semester" class="hidden space-y-4">
                                <div>
                                    <label for="semester" class="block font-medium text-sm text-gray-700">Semester</label>
                                    <select name="semester" id="semester" class="block mt-1 w-full rounded-md">
                                        <option value="1">Ganjil (Juli - Desember)</option>
                                        <option value="2">Genap (Januari - Juni)</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Opsi Tahun (Shared) -->
                            <div>
                                <label for="tahun" class="block font-medium text-sm text-gray-700">Tahun</label>
                                <input type="number" name="tahun" id="tahun" class="block mt-1 w-full rounded-md" value="{{ date('Y') }}" placeholder="Contoh: 2024" required>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Buat PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleReportOptions() {
            const type = document.getElementById('jenis_laporan').value;
            const bulanan = document.getElementById('opsi_bulanan');
            const semester = document.getElementById('opsi_semester');

            if (type === 'bulanan') {
                bulanan.style.display = 'block';
                semester.style.display = 'none';
            } else {
                bulanan.style.display = 'none';
                semester.style.display = 'block';
            }
        }
    </script>
</x-app-layout>