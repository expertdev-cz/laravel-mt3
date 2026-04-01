<?php

namespace Database\Seeders;

use App\Models\System\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminEmail = 'nevaril@expert-dev.cz';
        $passwordFromEnv = (string) env('SEED_ADMIN_PASSWORD', '');

        $admin = User::query()->where('email', $adminEmail)->first();

        if ($admin && $passwordFromEnv === '') {
            return;
        }

        $plainPassword = $passwordFromEnv !== '' ? $passwordFromEnv : Str::password(16);

        User::query()->updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin',
                'password' => Hash::make($plainPassword),
                'email_verified_at' => now(),
                'role_name' => 'admin',
            ]
        );

        if ($passwordFromEnv === '' && $this->command) {
            $this->command->warn('Generated temporary admin password (set SEED_ADMIN_PASSWORD to override): ' . $plainPassword);
        }
    }
}
