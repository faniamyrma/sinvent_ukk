<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = ['merk', 'seri', 'spesifikasi', 'stok', 'kategori_id', 'foto'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    public function barangmasuk()
    {
        return $this->hasMany(Barangmasuk::class, 'barang_id');
    }

    public function barangkeluar()
    {
        return $this->hasMany(Barangkeluar::class, 'barang_id');
    }
}
