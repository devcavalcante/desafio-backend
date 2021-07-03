<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('users')->insertOrIgnore(
            [
                [
                    'id' => Str::uuid(),
                    'name' => 'Lojista',
                    'email' => 'lojista@gmail.com',
                    'document' => rand(11111111, 99999999),
                    'password' => Hash::make('midias123'),
                    'role_id' => 'e0cb0a70-dbfb-11eb-8d19-0242ac130003',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id' => Str::uuid(),
                    'name' => 'Usuário normal',
                    'email' => 'usuario@gmail.com',
                    'document' => rand(11111111,99999999),
                    'password' => Hash::make('lojista123'),
                    'role_id' => 'b39b20da-dbfb-11eb-8d19-0242ac130003',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
            ]
        );
    }
}
