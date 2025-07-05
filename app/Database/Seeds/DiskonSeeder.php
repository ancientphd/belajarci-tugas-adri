<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\DiskonModel;

class DiskonSeeder extends Seeder
{
    public function run()
    {
        $model = new DiskonModel();
        $now = new \DateTime();

        for ($i = 0; $i < 10; $i++) {
            $tanggal = clone $now;
            $tanggal->modify("+$i days");

            $model->insert([
                'tanggal'    => $tanggal->format('Y-m-d'),
                'nominal'    => rand(100000, 300000),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}

