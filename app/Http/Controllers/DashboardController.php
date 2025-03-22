<?php
namespace App\Http\Controllers;

use App\Models\Terapi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
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

        return view('admin.dashboard.index', compact('terapi_rujuk', 'terapi_jalan', 'rujuk', 'jalan', 'month', 'year'));
    }

}
