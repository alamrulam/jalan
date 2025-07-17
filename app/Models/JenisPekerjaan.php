<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPekerjaan extends Model
{
    use HasFactory;
    protected $table = 'jenis_pekerjaans';
    protected $fillable = [
        'project_id',
        'nama_pekerjaan',
        'deskripsi',
        'progres'
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
