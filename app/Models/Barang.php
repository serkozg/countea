<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table   = 'barang';
    protected $guarded = ['id'];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
}
