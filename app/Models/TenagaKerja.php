<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenagaKerja extends Model
{
    use HasFactory;
    protected $table = 'tenaga_kerjas';
    protected $fillable = [
        'project_id',
        'nama_pekerja',
        'alamat_pekerja',
        'posisi',
        'honor_harian'
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
