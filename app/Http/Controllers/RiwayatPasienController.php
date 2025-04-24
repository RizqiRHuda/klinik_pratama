<?php
namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Terapi;
use Illuminate\Http\Request;

class RiwayatPasienController extends Controller
{
    public function index()
    {
        // $data = Terapi::with('pasien', 'obat', 'jenisLayanan')->whereHas('pasien', function ($q) {
        //     $q->where('id_pasien', 4);
        // })->get();
        // dd($data);
        return view('admin.riwayat.index_personal');
    }

    public function pilihPasien(Request $request)
    {
        $pasien = Pasien::select('no_rm', 'nama_pasien')
            ->where(function ($query) use ($request) {
                $query->where('nama_pasien', 'like', '%' . $request->q . '%')
                    ->orWhere('no_rm', 'like', '%' . $request->q . '%');
            })->get();

        $result = $pasien->map(function ($item){
            return [
                'id' => $item->no_rm,
                'text' => $item->no_rm . '-' . $item->nama_pasien
            ];
        });

        return response()->json($result);
    }

    public function getRiwayat($no_rm)
    {
        $data = Terapi::with('pasien', 'obat', 'jenisLayanan')->whereHas('pasien', function ($q) use ($no_rm){
            $q->where('no_rm', $no_rm);
        })->get();

        return response()->json($data);
    }
}
