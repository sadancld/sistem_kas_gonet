<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSaldoSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'saldo_akhir' => 0,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('kas_saldo')->insert($data);
    }
}