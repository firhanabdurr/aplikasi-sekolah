<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; }
        .container { width: 100%; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #f2f2f2; }
        .text-left { text-align: left; }
        .lunas { color: green; }
        .belum-lunas { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $title }}</h1>
        </div>

        <h3>Daftar Siswa Lunas</h3>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th class="text-left">NIS</th>
                    <th class="text-left">Nama Siswa</th>
                    <th class="text-left">Kelas</th>
                    @foreach($bulan_semester as $bulan)
                        <th>{{ \Carbon\Carbon::create()->month($bulan)->format('M') }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($reportData as $data)
                    @if($data['lunas_semua'])
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td class="text-left">{{ $data['student']->nomor_induk }}</td>
                        <td class="text-left">{{ $data['student']->nama_lengkap }}</td>
                        <td class="text-left">{{ $data['student']->kelas }}</td>
                        @foreach($data['status_pembayaran'] as $status)
                            <td class="lunas">{{ $status }}</td>
                        @endforeach
                    </tr>
                    @endif
                @endforeach
                @if($no == 1)
                <tr><td colspan="{{ 4 + count($bulan_semester) }}">Tidak ada siswa yang lunas semua bulan.</td></tr>
                @endif
            </tbody>
        </table>
        
        <h3>Daftar Siswa Belum Lunas</h3>
        <table>
            <thead>
                 <tr>
                    <th>No.</th>
                    <th class="text-left">NIS</th>
                    <th class="text-left">Nama Siswa</th>
                    <th class="text-left">Kelas</th>
                    @foreach($bulan_semester as $bulan)
                        <th>{{ \Carbon\Carbon::create()->month($bulan)->format('M') }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($reportData as $data)
                    @if(!$data['lunas_semua'])
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td class="text-left">{{ $data['student']->nomor_induk }}</td>
                        <td class="text-left">{{ $data['student']->nama_lengkap }}</td>
                        <td class="text-left">{{ $data['student']->kelas }}</td>
                        @foreach($data['status_pembayaran'] as $status)
                            <td class="{{ $status == 'Lunas' ? 'lunas' : 'belum-lunas' }}">{{ $status }}</td>
                        @endforeach
                    </tr>
                    @endif
                @endforeach
                @if($no == 1)
                <tr><td colspan="{{ 4 + count($bulan_semester) }}">Semua siswa sudah lunas.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>