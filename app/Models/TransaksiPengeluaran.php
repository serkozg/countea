<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiPengeluaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table   = 'transaksi_pengeluaran';
    protected $guarded = ['id'];

    public function mtransaksi()
    {
        return $this->belongsTo(MasterTransaksi::class);
    }
}
