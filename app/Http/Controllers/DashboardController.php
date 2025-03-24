<?php
namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Terapi;
use Illuminate\Http\Request;
use App\Exports\ObatOrderExport;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = Terapi::select('anamnesa')->get();
        $date = $request->input('date', today());

        $terapi_rujuk = Terapi::where('id_jenis_layanan', 1)
            ->whereDate('created_at', $date)
            ->count();

        $terapi_jalan = Terapi::where('id_jenis_layanan', 2)
            ->whereDate('created_at', $date)
            ->count();

        $year = $request->input('year', now()->year); 

        $data_rujuk = Terapi::where('id_jenis_layanan', 1)
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $data_jalan = Terapi::where('id_jenis_layanan', 2)
            ->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

       
        $months = range(1, 12);
        $rujuk  = [];
        $jalan  = [];

        foreach ($months as $month) {
            $rujuk[] = $data_rujuk[$month] ?? 0;
            $jalan[] = $data_jalan[$month] ?? 0;
        }

        $obatAman = Obat::where('status_stock', 'Aman')->get();
        $obatOrder = Obat::where('status_stock', 'Tidak Aman')->get();
       

        return view('admin.dashboard.index', compact('terapi_rujuk', 'terapi_jalan', 'rujuk', 'jalan', 'month', 'year', 'obatAman', 'obatOrder'));
    }

    public function exportObatOrder()
    {
        $tanggal  = date('Y-m-d'); // Ambil tanggal saat ini
        $fileName = "Obat_Order_{$tanggal}.xlsx";

        return Excel::download(new ObatOrderExport, $fileName);
    }

    public function getAnamnesa(Request $request)
    {

    }

}
