<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);
        Team::factory()->createOne(['user_id'=>$user->first()->id]);
        $this->call(PermissionsSeeder::class);

        $this->call(CategorySeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(EquipmentSeeder::class);
        $this->call(ManufacturerSeeder::class);
        $this->call(UserSeeder::class);
    }
}
