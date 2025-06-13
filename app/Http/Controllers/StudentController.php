<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SavingsTransaction;
use App\Models\SppPayment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_induk', 'like', '%' . $request->search . '%');
        }

        $students = $query->latest()->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_induk' => 'required|string|unique:students,nomor_induk',
            'nama_lengkap' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'alamat' => 'nullable|string',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function show(Student $student)
    {
        $savings = $student->savings()->latest()->paginate(10);
        $spp_payments = $student->sppPayments()->get()->keyBy(function($item) {
            return $item->tahun . '-' . $item->bulan;
        });
        
        $currentYear = date('Y');
        $months = [];
        for ($m=1; $m<=12; ++$m) {
            $months[] = date('F', mktime(0, 0, 0, $m, 1));
        }

        return view('students.show', compact('student', 'savings', 'spp_payments', 'months', 'currentYear'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nomor_induk' => 'required|string|unique:students,nomor_induk,' . $student->id,
            'nama_lengkap' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'alamat' => 'nullable|string',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Siswa berhasil dihapus.');
    }

    public function storeSaving(Request $request, Student $student)
    {
        $request->validate([
            'jenis_transaksi' => 'required|in:setor,tarik',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_transaksi' => 'required|date',
        ]);

        if ($request->jenis_transaksi == 'tarik' && $request->jumlah > $student->balance) {
            return back()->with('error', 'Saldo tidak mencukupi untuk penarikan.');
        }

        $student->savings()->create($request->all());

        return back()->with('success', 'Transaksi tabungan berhasil disimpan.');
    }

    public function storeSpp(Request $request, Student $student)
    {
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer',
            'jumlah_bayar' => 'required|numeric|min:1',
        ]);

        SppPayment::create([
            'student_id' => $student->id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => Carbon::now(),
        ]);

        return back()->with('success', 'Pembayaran SPP berhasil disimpan.');
    }
}