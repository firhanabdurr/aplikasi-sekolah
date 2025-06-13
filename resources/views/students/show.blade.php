<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Siswa: {{ $student->nama_lengkap }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Student Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Informasi Siswa</h3>
                <p><strong>Nomor Induk:</strong> {{ $student->nomor_induk }}</p>
                <p><strong>Nama:</strong> {{ $student->nama_lengkap }}</p>
                <p><strong>Kelas:</strong> {{ $student->kelas }}</p>
                <p><strong>Alamat:</strong> {{ $student->alamat ?? '-' }}</p>
            </div>

            <!-- Savings Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Tabungan Siswa</h3>
                <p class="mb-4 text-xl"><strong>Saldo Saat Ini:</strong> Rp {{ number_format($student->balance, 2, ',', '.') }}</p>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">{{ session('error') }}</div>
                @endif

                <form action="{{ route('students.savings.store', $student) }}" method="POST" class="mb-6 p-4 border rounded-md">
                    @csrf
                    <h4 class="font-semibold mb-2">Input Transaksi Baru</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="tanggal_transaksi" class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
                        </div>
                        <div>
                            <label for="jenis_transaksi" class="block text-sm font-medium text-gray-700">Jenis</label>
                            <select name="jenis_transaksi" id="jenis_transaksi" class="mt-1 block w-full rounded-md border-gray-300" required>
                                <option value="setor">Setor</option>
                                <option value="tarik">Tarik</option>
                            </select>
                        </div>
                        <div>
                            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah (Rp)</label>
                            <input type="number" name="jumlah" id="jumlah" min="1" class="mt-1 block w-full rounded-md border-gray-300" required>
                        </div>
                    </div>
                    <div class="mt-4">
                         <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-600">Simpan Transaksi</button>
                    </div>
                </form>

                <h4 class="font-semibold mb-2">Riwayat Transaksi</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-2 px-4 text-left">Tanggal</th>
                                <th class="py-2 px-4 text-left">Jenis</th>
                                <th class="py-2 px-4 text-left">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($savings as $saving)
                            <tr class="border-b">
                                <td class="py-2 px-4">{{ \Carbon\Carbon::parse($saving->tanggal_transaksi)->format('d M Y') }}</td>
                                <td class="py-2 px-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $saving->jenis_transaksi == 'setor' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($saving->jenis_transaksi) }}
                                    </span>
                                </td>
                                <td class="py-2 px-4">Rp {{ number_format($saving->jumlah, 2, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center py-4">Belum ada transaksi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $savings->links() }}</div>
            </div>

            <!-- SPP Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Pembayaran SPP - Tahun {{ $currentYear }}</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($months as $index => $monthName)
                        @php
                            $monthNumber = $index + 1;
                            $paymentKey = $currentYear . '-' . $monthNumber;
                            $isPaid = isset($spp_payments[$paymentKey]);
                        @endphp
                        <div class="p-4 border rounded-lg {{ $isPaid ? 'bg-green-100' : 'bg-gray-50' }}">
                            <h5 class="font-bold">{{ $monthName }}</h5>
                            @if($isPaid)
                                <p class="text-green-600 font-semibold">Lunas</p>
                                <p class="text-xs text-gray-500">Dibayar pada {{ \Carbon\Carbon::parse($spp_payments[$paymentKey]->tanggal_bayar)->format('d M Y') }}</p>
                            @else
                                <form action="{{ route('students.spp.store', $student) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="bulan" value="{{ $monthNumber }}">
                                    <input type="hidden" name="tahun" value="{{ $currentYear }}">
                                    <div class="mt-2">
                                        <label for="spp-{{$monthNumber}}" class="text-sm">Jumlah Bayar</label>
                                        <input type="number" name="jumlah_bayar" id="spp-{{$monthNumber}}" class="w-full text-sm rounded-md border-gray-300" placeholder="e.g. 150000" required>
                                    </div>
                                    <button type="submit" class="mt-2 w-full text-sm px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Bayar</button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>