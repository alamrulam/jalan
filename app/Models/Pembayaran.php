<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayarans';
    protected $fillable = [
        'project_id',
        'jenis_pekerjaan_id',
        'tanggal_pembayaran',
        'jenis_transaksi',
        'keterangan',
        'jumlah'
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function jenisPekerjaan()
    {
        return $this->belongsTo(JenisPekerjaan::class);
    }
}
