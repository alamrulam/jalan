<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_proyek',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis_proyek',

    ];

    /**
     * Mendapatkan semua laporan harian untuk proyek ini.
     */
    public function dailyReports(): HasMany
    {
        return $this->hasMany(DailyReport::class);
    }
    //Definisikan relasi jika ada, misalnya dengan User (Admin)
    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by_admin_id');
    }

    /**
     * User (Pelaksana) yang ditugaskan ke Proyek ini.
     */
    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id');
    }

    public function profilPerusahaan()
    {
        return $this->hasOne(ProfilPerusahaan::class);
    }
    public function tenagaKerja()
    {
        return $this->hasMany(TenagaKerja::class);
    }
    public function jenisPekerjaan()
    {
        return $this->hasMany(JenisPekerjaan::class);
    }
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
