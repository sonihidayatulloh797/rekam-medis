<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyDiagnosaSeeder extends Seeder
{
    public function run(): void
    {
        // Insert user Petugas Dummy
        DB::table('users')->insert([
            'name' => 'Petugas Dummy',
            'email' => 'petugas@example.com',
            'password' => Hash::make('password'),
            'phone' => '081298765432',
            'role' => 2, // angka, sesuai dengan struktur kolom role
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ICD Diagnosa
        DB::table('icds')->insert([
            ['code' => 'A00', 'name_id' => 'Kolera', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'B00', 'name_id' => 'Infeksi Herpes', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Pasien
        $pasienId = DB::table('pasien')->insertGetId([
            'no_rm' => 'RM001',
            'nama' => 'Pasien Dummy',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Dokter
        $dokterId = DB::table('dokter')->insertGetId([
            'nama' => 'Dr. Dummy',
            'no_hp' => '08123456789',
            'poli' => 'Poli Umum',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Ambil ID user petugas yang tadi dibuat
        $petugasId = DB::table('users')->where('email', 'petugas@example.com')->value('id');

        // Rekam
        $rekamId = DB::table('rekam')->insertGetId([
            'no_rekam' => 'REKAM-001',
            'tgl_rekam' => '2025-07-09',
            'pasien_id' => $pasienId,
            'dokter_id' => $dokterId,
            'poli' => 'Poli Umum',
            'keluhan' => 'Demam tinggi',
            'biaya_pemeriksaan' => 10000,
            'biaya_tindakan' => 5000,
            'biaya_obat' => 2500,
            'total_biaya' => 17500,
            'status' => 1,
            'petugas_id' => $petugasId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Rekam Diagnosa
        DB::table('rekam_diagnosa')->insert([
            [
                'rekam_id' => $rekamId,
                'pasien_id' => $pasienId,
                'diagnosa' => 'A00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'rekam_id' => $rekamId,
                'pasien_id' => $pasienId,
                'diagnosa' => 'B00',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
