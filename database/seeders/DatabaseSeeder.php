<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Category;
use App\Models\Pendaftaran;
use Illuminate\Database\Seeder;
use App\Models\OpenRegistration;
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
            'email' => 'ciptowirawan.CW@gmail.com',
            'password' => Hash::make('progress#2023')
        ]);

        Event::create([
            'event_name' => "membership",
            'amount' => 1500000
        ]);

        // OpenRegistration::create([
        //     'kode_status' => 'open-registration',
        //     'value' => 'early'
        // ]);

        $this->call([
            PermissionSeeder::class,
        ]);
    }
}
