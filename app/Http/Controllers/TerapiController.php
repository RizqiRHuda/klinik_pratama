<?php
namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Terapi;
use App\Models\TerapiObat;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TerapiController extends Controller
{
    public function index()
    {
        return view('admin.terapi.index_terapi');
    }

    public function indexRiwayat(Request $request)
{
    if ($request->ajax()) {
        $terapis = Terapi::with('pasien', 'jenisLayanan', 'obat');  // Start the query builder, no `get()` yet

        if ($request->has('start_date') && $request->has('end_date')) {
            $terapis->whereBetween('tgl_terapi', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay(),
            ]);
        }

        if ($request->has('no_rm') && $request->no_rm) {
            $terapis->whereHas('pasien', function($query) use ($request) {
                $query->where('no_rm', $request->no_rm);
            });
        }

        $terapis = $terapis->get();  // Now you can call `get()` after applying your filters

        return DataTables::of($terapis)
            ->addIndexColumn()
            ->editColumn('tgl_terapi', function ($row) {
                return $row->tgl_terapi ? \Carbon\Carbon::parse($row->tgl_terapi)->format('d-m-Y') : '-';
            })
            ->editColumn('jenisLayanan', function ($row) {
                return $row->jenisLayanan == 'rujuk' ? 'Rujuk' : 'Rawat Jalan';
            })
            ->editColumn('pemeriksaan', function ($row) {
                $pemeriksaan = json_decode($row->pemeriksaan, true);
                $output      = '<ul>';
                $output .= '<li>TB: ' . ($pemeriksaan['tb'] ?? '-') . ' cm</li>';
                $output .= '<li>BB: ' . ($pemeriksaan['bb'] ?? '-') . ' kg</li>';
                $output .= '<li>Suhu: ' . ($pemeriksaan['suhu'] ?? '-') . ' °C</li>';
                $output .= '<li>Tensi: ' . ($pemeriksaan['tensi'] ?? '-') . ' mmHg</li>';
                $output .= '<li>Nadi: ' . ($pemeriksaan['nadi'] ?? '-') . ' bpm</li>';
                $output .= '<li>Pernafasan: ' . ($pemeriksaan['pernafasan'] ?? '-') . ' x/menit</li>';
                $output .= '</ul>';
                return $output;
            })
            ->addColumn('obat', function ($row) {
                if ($row->obat->isEmpty()) {
                    return 'Tidak ada obat';
                }

                $obatList = '';
                foreach ($row->obat as $obat) {
                    $obatList .= '-' . $obat->nama_obat . ' [' . $obat->pivot->jumlah_obat . ' ' . $obat->satuan . ']<br>';
                }
                return $obatList;
            })
            ->rawColumns(['pemeriksaan', 'obat'])
            ->make(true);
    }

    return view('admin.terapi.table_riwayat');
}

    

    public function cariPasien($no_rm)
    {
        $pasien = Pasien::where('no_rm', $no_rm)->first();

        if ($pasien) {
            return response()->json($pasien);
        } else {
            return response()->json(['error' => 'Pasien tidak ditemukan!'], 404);
        }
    }

    public function getObat()
    {
        $obat = Obat::select('id', 'nama_obat')->get();
        return response()->json($obat);
    }

    public function simpan(Request $request)
    {
        DB::beginTransaction();
        try {
            $jenisPelayananMap = [
                'rujuk'       => 1,
                'rawat_jalan' => 2,
                'batal'       => 3,
            ];

            $idJenisLayanan = isset($jenisPelayananMap[$request->jenis_pelayanan])
            ? $jenisPelayananMap[$request->jenis_pelayanan]
            : null;

            if (! $idJenisLayanan) {
                throw new Exception('Jenis pelayanan tidak valid.');
            }

            $terapi = Terapi::create([
                'id_pasien'        => $request->id_pasien,
                'tgl_terapi'       => $request->tgl_terapi,
                'anamnesa'         => $request->anamnesa,
                'pemeriksaan'      => json_encode([
                    'tb'         => $request->tb,
                    'bb'         => $request->bb,
                    'suhu'       => $request->suhu,
                    'tensi'      => $request->tensi,
                    'nadi'       => $request->nadi,
                    'pernafasan' => $request->pernafasan,
                ]),
                'diagnosa'         => $request->diagnosa,
                'pengobatan'       => json_encode($request->pengeluaran), // Simpan sebagai JSON
                'id_jenis_layanan' => $idJenisLayanan,                    // Gunakan ID numerik di sini
            ]);

            // Simpan data obat jika ada
            if ($request->has('obat')) {
                foreach ($request->obat as $obatItem) {
                    $id_obat     = $obatItem;
                    $jumlah_obat = $request->pengeluaran[0];

                    TerapiObat::create([
                        'id_terapi'   => $terapi->id,
                        'id_obat'     => $id_obat,
                        'jumlah_obat' => $jumlah_obat,
                    ]);

                    $obat = Obat::findOrFail($id_obat);

                    $obat->pemakaian += $jumlah_obat;

                    $obat->updateStock(); // Memanggil updateStock() untuk menghitung stok_akhir

                }
            }

            DB::commit();

            // Jika AJAX request, kirimkan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data terapi berhasil disimpan.']);
            }

            // Jika bukan AJAX, redirect ke halaman sebelumnya
            return redirect()->back()->with('success', 'Data terapi berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Jika AJAX request, kirimkan response JSON
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menyimpan terapi: ' . $e->getMessage()]);
            }

            // Jika bukan AJAX, redirect ke halaman sebelumnya dengan error
            return redirect()->back()->with('error', 'Gagal menyimpan terapi: ' . $e->getMessage());
        }
    }

    public function getPasien(Request $request)
    {
        $pasien = Pasien::select('no_rm', 'nama_pasien')
            ->where('nama_pasien', 'like', '%' . $request->q . '%') 
            ->get();

        return response()->json($pasien);
    }

}
