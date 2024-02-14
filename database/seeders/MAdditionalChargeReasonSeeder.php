<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\MAdditionalChargeReason;

class MAdditionalChargeReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('m_additional_charge_reasons')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $m_additional_charge_reasons = [
            [
                'id' => 1,
                'name' => 'Absence',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'Leave',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'name' => 'Training',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'name' => 'Department Order',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => null,
            ],
        ];

        MAdditionalChargeReason::insert($m_additional_charge_reasons);
    }
}
