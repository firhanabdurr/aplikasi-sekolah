<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'tanggal_transaksi',
        'jenis_transaksi',
        'jumlah',
        'keterangan',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}