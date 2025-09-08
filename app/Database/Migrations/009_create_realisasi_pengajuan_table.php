<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRealisasiPengajuanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'pengajuan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'kas_keluar_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'metode_pembayaran' => [
                'type' => 'ENUM',
                'constraint' => ['uang_sendiri', 'minta_uang'],
            ],
            'status_realisasi' => [
                'type' => 'ENUM',
                'constraint' => ['proses', 'selesai'],
                'default' => 'proses',
            ],
            'tanggal_realisasi' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('pengajuan_id', 'pengajuan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kas_keluar_id', 'kas_keluar', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('realisasi_pengajuan');
    }

    public function down()
    {
        $this->forge->dropTable('realisasi_pengajuan');
    }
}