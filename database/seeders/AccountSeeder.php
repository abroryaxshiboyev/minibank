<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();

        foreach ($users as $user) {
            \App\Models\Account::firstOrCreate([
                'user_id' => $user->id,
            ], [
                'balance' => rand(100, 5000),
            ]);
        }
    }
}
