<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKasMasukTable extends Migration
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
            'nominal' => [
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
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('kas_masuk');
    }

    public function down()
    {
        $this->forge->dropTable('kas_masuk');
    }
}