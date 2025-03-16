<?php
namespace App\Http\Controllers;

use App\Models\Pasien;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasienController extends Controller
{
    public function index()
    {
        return view('admin.pasien.index_pasien');
    }

    public function simpan(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            Pasien::create([
                'no_rm'          => $request->no_rm,
                'nik'            => $request->nik,
                'tgl_lahir'      => $request->tgl_lahir,
                'jk'             => $request->jk, // Pastikan L atau P
                'no_hp'          => $request->no_hp,
                'nama_pasien'    => $request->nama_pasien,
                'alamat'         => $request->alamat,
                'riwayat_alergi' => $request->riwayat_alergi,
                'pekerjaan'      => $request->pekerjaan,
            ]);

            DB::commit();
            return response()->json(['message' => 'Data pasien berhasil disimpan.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }

    public function getDataPasien(Request $request)
    {
        $query = Pasien::select([
            'id', 'no_rm', 'nama_pasien', 'nik', 'alamat', 'no_hp',
            'tgl_lahir', 'jk', 'pekerjaan', 'riwayat_alergi',
        ]);

        return DataTables::of($query)
            ->addIndexColumn() // Menambahkan nomor otomatis
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-warning edit" data-id="' . $row->id . '">Edit</button>
                    <button class="btn btn-sm btn-danger delete" data-id="' . $row->id . '">Hapus</button>';
            })
            ->rawColumns(['action']) // Mengizinkan kolom action berisi HTML
            ->make(true);
    }

    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return response()->json($pasien);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_pasien'    => 'required|string|max:255',
            'alamat'         => 'required|string',
            'pekerjaan'      => 'required|string|max:100',
            'no_hp'          => 'required|string|digits_between:6,15', // Memastikan hanya angka 10-15 digit
            'riwayat_alergi' => 'nullable|string',
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->update($data);

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

}
