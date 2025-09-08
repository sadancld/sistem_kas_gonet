<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePengajuanTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nominal' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'deadline' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'diproses', 'diterima', 'ditolak'],
                'default' => 'pending',
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengajuan');
    }

    public function down()
    {
        $this->forge->dropTable('pengajuan');
    }
}