<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKasKeluarTable extends Migration
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
                'null' => true,
            ],
            'nominal' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'file_nota' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
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
        $this->forge->createTable('kas_keluar');
    }

    public function down()
    {
        $this->forge->dropTable('kas_keluar');
    }
}