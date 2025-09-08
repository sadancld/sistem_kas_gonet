<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKasSaldoTable extends Migration
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
            'saldo_akhir' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('kas_saldo');
    }

    public function down()
    {
        $this->forge->dropTable('kas_saldo');
    }
}