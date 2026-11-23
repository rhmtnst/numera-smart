<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LearningDomainSeeder::class,
            LearningMaterialSeeder::class,
            GradeFourContentSeeder::class,
            GradeFiveSixContentSeeder::class,
            // Jalankan terakhir agar bank verifikasi dibuat setelah seluruh topik IV-VI tersedia.
            NewmanVerificationSeeder::class,
        ]);
    }
}
