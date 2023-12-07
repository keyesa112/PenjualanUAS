<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    use HasFactory;

    
    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'idSatuan'); // Assuming 'idSatuan' is the foreign key in the 'barangs' table
    }
    protected $table = 'barang';
    protected $dates = ['deleted_at'];
    public $timestamps = false;
}
