<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateSuperAdmin extends Command
{
    protected $signature = 'admin:create-super';

    protected $description = 'Membuat akun Super Admin NUMERA SMART';

    public function handle(): int
    {
        $name = trim($this->ask('Nama Super Admin'));

        if ($name === '') {
            $this->error('Nama tidak boleh kosong.');
            return self::FAILURE;
        }

        $email = strtolower(trim($this->ask('Email Super Admin')));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Format email tidak valid.');
            return self::FAILURE;
        }

        if (User::where('email', $email)->exists()) {
            $this->error('Email sudah terdaftar. Gunakan email lain.');
            return self::FAILURE;
        }

        $password = $this->secret('Masukkan password');

        if (strlen($password) < 8) {
            $this->error('Password minimal 8 karakter.');
            return self::FAILURE;
        }

        $confirmation = $this->secret('Ulangi password');

        if ($password !== $confirmation) {
            $this->error('Konfirmasi password tidak cocok.');
            return self::FAILURE;
        }

        User::forceCreate([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => 'admin',
        ]);

        $this->newLine();
        $this->info('Akun Super Admin berhasil dibuat!');
        $this->line('Email: '.$email);
        $this->line('Role: Super Admin');

        return self::SUCCESS;
    }
}
