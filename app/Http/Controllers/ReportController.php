<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SavingsTransaction;
use App\Models\SppPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'jenis_laporan' => 'required|in:bulanan,semester',
            'bulan' => 'required_if:jenis_laporan,bulanan|integer',
            'tahun' => 'required|integer',
            'semester' => 'required_if:jenis_laporan,semester|in:1,2', // 1: Ganjil, 2: Genap
        ]);
        
        $jenis_laporan = $request->input('jenis_laporan');
        $tahun = $request->input('tahun');

        if ($jenis_laporan == 'bulanan') {
            $bulan = $request->input('bulan');
            return $this->monthlyReport($bulan, $tahun);
        } elseif ($jenis_laporan == 'semester') {
            $semester = $request->input('semester');
            return $this->semesterReport($semester, $tahun);
        }
    }

    private function monthlyReport($bulan, $tahun)
    {
        $namaBulan = Carbon::create()->month($bulan)->format('F');
        $title = "Laporan Keuangan Bulanan - {$namaBulan} {$tahun}";

        $pemasukan_spp = SppPayment::where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah_bayar');
        $pemasukan_tabungan = SavingsTransaction::whereMonth('tanggal_transaksi', $bulan)
            ->whereYear('tanggal_transaksi', $tahun)
            ->where('jenis_transaksi', 'setor')
            ->sum('jumlah');
        
        $total_pemasukan = $pemasukan_spp + $pemasukan_tabungan;

        $pengeluaran_tabungan = SavingsTransaction::whereMonth('tanggal_transaksi', $bulan)
            ->whereYear('tanggal_transaksi', $tahun)
            ->where('jenis_transaksi', 'tarik')
            ->sum('jumlah');
        
        $total_pengeluaran = $pengeluaran_tabungan;

        $data = compact(
            'title', 'bulan', 'tahun', 'namaBulan',
            'pemasukan_spp', 'pemasukan_tabungan', 'total_pemasukan',
            'pengeluaran_tabungan', 'total_pengeluaran'
        );

        $pdf = Pdf::loadView('pdf.monthly_report', $data);
        return $pdf->download("laporan-bulanan-{$namaBulan}-{$tahun}.pdf");
    }

    private function semesterReport($semester, $tahun_ajaran)
    {
        // Semester 1 (Ganjil): Juli - Desember
        // Semester 2 (Genap): Januari - Juni
        $bulan_semester = $semester == 1 ? range(7, 12) : range(1, 6);
        $nama_semester = $semester == 1 ? 'Ganjil' : 'Genap';
        $tahun_pertama = $tahun_ajaran;
        $tahun_kedua = $tahun_ajaran + 1;

        $title = "Laporan Status SPP Semester {$nama_semester} Tahun Ajaran {$tahun_pertama}/{$tahun_kedua}";
        
        $students = Student::with('sppPayments')->get();
        $reportData = [];

        foreach ($students as $student) {
            $status_pembayaran = [];
            $lunas_semua = true;

            foreach ($bulan_semester as $bulan) {
                 // Tentukan tahun berdasarkan bulan semester
                $current_year = ($semester == 1) ? $tahun_pertama : $tahun_kedua;
                
                $payment = $student->sppPayments
                    ->where('bulan', $bulan)
                    ->where('tahun', $current_year)
                    ->first();

                if ($payment) {
                    $status_pembayaran[$bulan] = 'Lunas';
                } else {
                    $status_pembayaran[$bulan] = 'Belum Lunas';
                    $lunas_semua = false;
                }
            }
            
            $reportData[] = [
                'student' => $student,
                'status_pembayaran' => $status_pembayaran,
                'lunas_semua' => $lunas_semua,
            ];
        }
        
        $data = compact('title', 'reportData', 'bulan_semester');
        
        $pdf = Pdf::loadView('pdf.semester_report', $data)->setPaper('a4', 'landscape');
        return $pdf->download("laporan-spp-semester-{$nama_semester}-{$tahun_pertama}.pdf");
    }
}