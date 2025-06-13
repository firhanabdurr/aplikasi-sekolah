<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'bulan',
        'tahun',
        'jumlah_bayar',
        'tanggal_bayar',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}