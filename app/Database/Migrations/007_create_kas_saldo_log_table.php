<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKasSaldoLogTable extends Migration
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
            'kas_masuk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'kas_keluar_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'nominal' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'tipe' => [
                'type' => 'ENUM',
                'constraint' => ['masuk', 'keluar'],
            ],
            'saldo_sebelum' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'saldo_sesudah' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kas_masuk_id', 'kas_masuk', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('kas_keluar_id', 'kas_keluar', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('kas_saldo_log');
    }

    public function down()
    {
        $this->forge->dropTable('kas_saldo_log');
    }
}