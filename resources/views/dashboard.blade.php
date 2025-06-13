<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat datang di Aplikasi Administrasi Sekolah!") }}
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Link ke Manajemen Siswa -->
                        <a href="{{ route('students.index') }}" class="block p-6 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 transition">
                            <h3 class="font-bold text-lg">Manajemen Siswa</h3>
                            <p class="mt-2">Kelola data siswa, tabungan, dan pembayaran SPP.</p>
                        </a>

                        <!-- Link ke Laporan -->
                        <a href="{{ route('reports.index') }}" class="block p-6 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 transition">
                            <h3 class="font-bold text-lg">Cetak Laporan</h3>
                            <p class="mt-2">Buat laporan bulanan dan semester dalam format PDF.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>