<?php
    namespace App\Models;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class DailyReport extends Model
    {
        use HasFactory;

        protected $fillable = [
            'project_id',
            'user_id', // Pelaksana yang membuat
            'tanggal_laporan',
            'status_laporan', // default 'pending' di migration
            'catatan_admin',
        ];

        public function project(): BelongsTo
        {
            return $this->belongsTo(Project::class);
            
        }

        public function user(): BelongsTo // Pelaksana
        {
            return $this->belongsTo(User::class);
        }

        public function reportItems(): HasMany
        {
            return $this->hasMany(ReportItem::class);
        }
    }