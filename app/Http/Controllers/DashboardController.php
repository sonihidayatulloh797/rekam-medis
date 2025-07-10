<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role_display() == "Admin") {
            // Diagnosa terbanyak
            $dataDiagnosaTerbanyak = DB::select("
                SELECT aa.diagnosa, aa.total, ic.name_id
                FROM (
                    SELECT sc.diagnosa AS diagnosa, COUNT(sc.diagnosa) AS total
                    FROM (
                        SELECT a.diagnosa
                        FROM rekam_diagnosa a
                        LEFT JOIN rekam r ON r.id = a.rekam_id
                        WHERE a.diagnosa IS NOT NULL AND r.tgl_rekam LIKE '%2025-%'

                        UNION ALL

                        SELECT rg.diagnosa
                        FROM rekam_gigi rg
                        WHERE rg.created_at LIKE '%2025-%'
                    ) sc
                    GROUP BY sc.diagnosa
                ) aa
                LEFT JOIN icds ic ON ic.code = aa.diagnosa
                ORDER BY aa.total DESC
                LIMIT 10
            ");

            return view('dashboard.admin', compact('dataDiagnosaTerbanyak'));
        }

        if (auth()->user()->role_display() == "Pendaftaran") {
            return view('dashboard.registrasi');
        }

        if (auth()->user()->role_display() == "Dokter") {
            return view('dashboard.dokter');
        }

        if (auth()->user()->role_display() == "Apotek") {
            return view('dashboard.obat');
        }
    }
}
