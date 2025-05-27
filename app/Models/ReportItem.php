<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class ReportItem extends Model
    {
        use HasFactory;

        protected $fillable = [
            'daily_report_id',
            'jenis_pekerjaan',
            'panjang',
            'lebar',
            'tinggi_atau_tebal',
            'volume_dihitung',
            'satuan_volume',
            'catatan_item',
        ];

        public function dailyReport(): BelongsTo
        {
            return $this->belongsTo(DailyReport::class);
        }
    }