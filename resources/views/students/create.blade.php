<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Siswa Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('students.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nomor_induk" class="block font-medium text-sm text-gray-700">Nomor Induk</label>
                                <input type="text" name="nomor_induk" id="nomor_induk" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('nomor_induk') }}" required>
                            </div>
                            <div>
                                <label for="nama_lengkap" class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('nama_lengkap') }}" required>
                            </div>
                             <div>
                                <label for="kelas" class="block font-medium text-sm text-gray-700">Kelas</label>
                                <input type="text" name="kelas" id="kelas" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('kelas') }}" required>
                            </div>
                            <div>
                                <label for="alamat" class="block font-medium text-sm text-gray-700">Alamat</label>
                                <textarea name="alamat" id="alamat" class="block mt-1 w-full rounded-md shadow-sm border-gray-300">{{ old('alamat') }}</textarea>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('students.index') }}" class="mr-4 px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>