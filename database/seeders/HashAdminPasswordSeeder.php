<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HashAdminPasswordSeeder extends Seeder
{
    public function run()
    {
        $admins = DB::table('admin')->get();

        foreach ($admins as $admin) {
            // Cek apakah password sudah di-hash atau belum
            if (!Hash::needsRehash($admin->adm_password)) {
                continue; // sudah hashed
            }

            DB::table('admin')
                ->where('id_admin', $admin->id_admin)
                ->update([
                    'adm_password' => Hash::make($admin->adm_password)
                ]);

            echo "Password admin {$admin->adm_username} telah di-hash.\n";
        }
    }
}