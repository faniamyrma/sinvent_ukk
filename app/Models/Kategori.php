<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';  //$table merupakan propertied

    protected $fillable = ['deskripsi', 'kategori'];
    
    public $incrementing = true;
    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}
