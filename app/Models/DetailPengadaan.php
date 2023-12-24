<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPengadaan extends Model
{
    use HasFactory;
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_idbarang', 'idbarang'); // Sesuaikan kunci asing disini
    }
}
