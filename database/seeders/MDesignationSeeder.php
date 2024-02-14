<?php

namespace Database\Seeders;

use App\Models\MDesignation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MDesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('m_designations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $designations = [
            [
                'id' => 1,
                'fk_role_id' => 1,
                'name' => 'Super Admin',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id' => 2,
                'fk_role_id' => 2,
                'name' => 'System Admin',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id' => 3,
                'fk_role_id' => 3,
                'name' => 'Nodal Officer',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'id' => 4,
                'fk_role_id' => 4,
                'name' => 'Content Manager',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ];

        MDesignation::insert($designations);
    }
}
