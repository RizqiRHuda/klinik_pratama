<?php
namespace App\Http\Controllers;

use App\Exports\ObatExport;
use App\Imports\ObatImport;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ObatController extends Controller
{
    public function index()
    {
        return view('admin.obat.index_obat');
    }

    public function getObat(Request $request)
    {
        if ($request->ajax()) {
            $obat = Obat::select(['id', 'nama_obat', 'stock_awal', 'pemakaian', 'pemasukan', 'stock_akhir', 'min_stock', 'satuan', 'status_stock']);

            return DataTables::of($obat)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<button class="btn btn-primary btn-sm edit" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-danger btn-sm delete" data-id="' . $row->id . '">Hapus</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function simpanObat(Request $request)
    {

        $request->validate([
            'nama_obat'  => 'required|unique:obat,nama_obat',
            'stock_awal' => 'required|integer',
            'pemakaian'  => 'required|integer',
            'pemasukan'  => 'required|integer',
            'min_stock'  => 'required|integer',
            'satuan'     => 'required|string',
        ]);

        DB::beginTransaction(); // Mulai transaksi

        try {
            $obat = Obat::create([
                'nama_obat'   => $request->nama_obat,
                'stock_awal'  => $request->stock_awal,
                'pemakaian'   => $request->pemakaian,
                'pemasukan'   => $request->pemasukan,
                'stock_akhir' => $request->stock_awal + $request->pemasukan - $request->pemakaian,
                'min_stock'   => $request->min_stock,
                'satuan'      => $request->satuan,
            ]);

            DB::commit(); // Simpan perubahan jika tidak ada error

            return response()->json([
                'success' => true,
                'message' => 'Data obat berhasil disimpan!',
                'data'    => $obat,
            ]);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan transaksi jika ada error

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data!',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function importObat(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx, csv',
        ]);

        Excel::import(new ObatImport, $request->file('file'));
        return redirect()->back()->with('success', 'Data obat berhasil diimpor!');
    }

    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return response()->json($obat);
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'nama_obat'  => 'required|string',
                'stock_awal' => 'required|integer',
                'pemakaian'  => 'required|integer',
                'pemasukan'  => 'required|integer',

                'min_stock'  => 'required|integer',
                'satuan'     => 'required|string',
            ]);

            $obat                = Obat::findOrFail($id);
            $data['stock_akhir'] = $data['stock_awal'] + $data['pemasukan'] - $data['pemakaian'];
            $obat->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data'    => $obat,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function export()
    {
        $tanggal  = date('Y-m-d'); 
        $namaFile = "daftar_obat_{$tanggal}.xlsx";

        return Excel::download(new ObatExport, $namaFile);
    }

}
