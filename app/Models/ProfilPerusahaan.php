<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPerusahaan extends Model
{
    use HasFactory;
    protected $table = 'profil_perusahaan'; // Sesuaikan nama tabel jika berbeda
    protected $fillable = [
        'project_id',
        'nama_lembaga',
        'alamat',
        'nama_ketua',
        'kontak'
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
