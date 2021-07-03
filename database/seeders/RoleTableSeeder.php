<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('roles')->insertOrIgnore(
            [
                [
                    'id' => 'b39b20da-dbfb-11eb-8d19-0242ac130003',
                    'type' => 'user',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => 'e0cb0a70-dbfb-11eb-8d19-0242ac130003',
                    'type' => 'shopkeeper',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
            ]
        );
    }
}
