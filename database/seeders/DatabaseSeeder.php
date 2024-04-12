<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Pendaftaran;
use App\Models\OpenRegistration;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'full_name' => 'MD307conv Admin',
            'email' => 'md307conv@admin.com',
            'password' => Hash::make('progress#2023')
        ]);

        OpenRegistration::create([
            'kode_status' => 'open-registration',
            'value' => 'early'
        ]);

        $this->call([
            PermissionSeeder::class,
        ]);
    }
}
