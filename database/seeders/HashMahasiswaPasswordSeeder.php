<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HashMahasiswaPasswordSeeder extends Seeder
{
    public function run()
    {
        $mahasiswas = DB::table('mahasiswa')->get();

        foreach ($mahasiswas as $mhs) {
            if (!Hash::needsRehash($mhs->password)) {
                continue;
            }

            DB::table('mahasiswa')
                ->where('id_mahasiswa', $mhs->id_mahasiswa)
                ->update([
                    'password' => Hash::make($mhs->password)
                ]);

            echo "✅ {$mhs->username} - {$mhs->nama} hashed\n";
        }
    }
}