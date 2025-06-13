<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Siswa') }}
            </h2>
            <a href="{{ route('students.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Tambah Siswa
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('students.index') }}" class="mb-4">
                        <div class="flex">
                            <input type="text" name="search" placeholder="Cari Nama atau NIS..." class="w-full rounded-l-md border-gray-300" value="{{ request('search') }}">
                            <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-r-md hover:bg-gray-700">Cari</button>
                        </div>
                    </form>
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">{{ session('success') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-800 text-white">
                                <tr>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Nomor Induk</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Nama Lengkap</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Kelas</th>
                                    <th class="py-3 px-4 uppercase font-semibold text-sm text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @forelse($students as $student)
                                <tr class="border-b">
                                    <td class="py-3 px-4">{{ $student->nomor_induk }}</td>
                                    <td class="py-3 px-4">{{ $student->nama_lengkap }}</td>
                                    <td class="py-3 px-4">{{ $student->kelas }}</td>
                                    <td class="py-3 px-4 flex gap-2">
                                        <a href="{{ route('students.show', $student) }}" class="text-blue-500 hover:text-blue-700">Detail</a>
                                        <a href="{{ route('students.edit', $student) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus siswa ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">Tidak ada data siswa.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>