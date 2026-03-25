<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  User::factory()->count(20)->create();


        // Cek apakah admin sudah ada
        if (User::where('username', 'admin')->doesntExist()) {
            
            User::create([
                'name' => 'Super Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin'), // Password: admin
                'role' => 'admin',
            ]);
            
            $this->command->info('✅ Admin pertama dibuat!');
            $this->command->info('👤 Username: admin');
            $this->command->info('🔑 Password: admin');
            
        } else {
            $this->command->warn('⚠️  Admin sudah ada!');
        }
    }
}