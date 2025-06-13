<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_induk',
        'nama_lengkap',
        'kelas',
        'alamat',
    ];

    public function savings()
    {
        return $this->hasMany(SavingsTransaction::class);
    }

    public function sppPayments()
    {
        return $this->hasMany(SppPayment::class);
    }

    public function getBalanceAttribute()
    {
        $setor = $this->savings()->where('jenis_transaksi', 'setor')->sum('jumlah');
        $tarik = $this->savings()->where('jenis_transaksi', 'tarik')->sum('jumlah');
        return $setor - $tarik;
    }
}