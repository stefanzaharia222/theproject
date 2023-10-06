<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        try {
            # Create super admin account
            $superAdmin = User::create([
                'first_name' => 'Administrator',
                'last_name' => 'Super',
                'email' => 'evotms-admin@evotms.ro',
                'phone' => '+40123123132',
                'password' => Hash::make('evotmslogin1234'),
                'type' => 'Super Admin',
            ]);
            $superAdmin->email_verified_at = Carbon::now();
            $superAdmin->assignRole('super-admin');
            $superAdmin->save();
        } catch (\Exception $e) {
            dd($e);
        }

    }
}
