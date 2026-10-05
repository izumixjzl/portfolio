<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Your admin login for /admin (set ADMIN_EMAIL / ADMIN_PASSWORD in .env first).
        User::updateOrCreate(
            ['email' => config('portfolio.admin_email')],
            [
                'name' => config('portfolio.name'),
                'password' => config('portfolio.admin_password'),
            ],
        );

        $this->call(PortfolioSeeder::class);
    }
}
