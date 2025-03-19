<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class TerapiController extends Controller
{
    public function index()
    {
        return view('admin.terapi.index_terapi');
    }

    public function indexRiwayat()
    {
        return view('admin.terapi.table_riwayat');
    }

    public function cariPasien($no_rm)
    {
        $pasien = Pasien::where('no_rm', $no_rm)->first();

        if($pasien){
            return response()->json($pasien);
        }else{
            return response()->json(['error' => 'Pasien tidak ditemukan!'], 404);
        }
    }
}
