<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Novel', 'Non-Fiksi', 'Biografi', 'Motivasi',
            'Religi', 'Anak-anak', 'Pendidikan', 'Teknologi',
        ];

        foreach ($kategoris as $nama) {
            Kategori::create([
                'nama' => $nama,
                'slug' => Str::slug($nama),
            ]);
        }
    }
}
