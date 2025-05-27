<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Cek apakah kolom dan foreign key ada sebelum mencoba menghapusnya
            if (Schema::hasColumn('projects', 'created_by_admin_id')) {
                // Nama foreign key biasanya: namatabel_namakolom_foreign
                // Dalam kasus Anda, errornya sudah menyebutkan nama constraint-nya:
                // 'projects_created_by_admin_id_foreign'

                // Coba dapatkan daftar foreign keys untuk tabel ini
                // $foreignKeys = Schema::getConnection()->getDoctrineSchemaManager()->listTableForeignKeys('projects');
                // $hasForeignKey = false;
                // foreach ($foreignKeys as $foreignKey) {
                //     if (in_array('created_by_admin_id', $foreignKey->getLocalColumns())) {
                //         $table->dropForeign(['created_by_admin_id']); // Coba hapus dengan nama kolom
                //         // atau $table->dropForeign($foreignKey->getName()); // Hapus dengan nama constraint
                //         $hasForeignKey = true;
                //         break;
                //     }
                // }
                // Jika Anda tahu nama constraint-nya secara pasti (dari pesan error):
                try {
                    $table->dropForeign('projects_created_by_admin_id_foreign');
                } catch (\Exception $e) {
                    // Jika foreign key tidak ditemukan (mungkin sudah terhapus atau nama berbeda),
                    // kita bisa mengabaikan error ini dan lanjut menghapus kolom.
                    // Log::warning("Foreign key 'projects_created_by_admin_id_foreign' tidak ditemukan saat migrasi: " . $e->getMessage());
                }

                // Setelah foreign key (jika ada) dihapus, baru hapus kolomnya
                $table->dropColumn('created_by_admin_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Jika migrasi di-rollback, tambahkan kembali kolomnya
            $table->unsignedBigInteger('created_by_admin_id')->nullable()->after('jenis_proyek'); // Sesuaikan dengan definisi awal
            // Tambahkan kembali foreign key jika memang ada sebelumnya
            // Pastikan tabel 'users' dan kolom 'id' ada
            $table->foreign('created_by_admin_id', 'projects_created_by_admin_id_foreign') // Beri nama constraint agar bisa dihapus lagi
                ->references('id')->on('users')
                ->onDelete('set null'); // atau onDelete('cascade') dll., sesuaikan
        });
    }
};
