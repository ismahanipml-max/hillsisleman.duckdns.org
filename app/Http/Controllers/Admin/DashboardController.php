<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lpk;
use App\Models\LpkService;
use App\Models\LpkPartner;
use App\Models\LpkGallery;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLpk = Lpk::count();
        $activeLpk = Lpk::where('aktif', true)->count();
        $totalServices = LpkService::count();
        $totalPartners = LpkPartner::count();
        $totalGalleries = LpkGallery::count();

        // Bidang count for bar chart
        $bidangCounts = Lpk::select('bidang', DB::raw('count(*) as total'))
            ->groupBy('bidang')
            ->orderByDesc('total')
            ->get();

        $latestLpks = Lpk::with(['services'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalLpk',
            'activeLpk',
            'totalServices',
            'totalPartners',
            'totalGalleries',
            'bidangCounts',
            'latestLpks'
        ));
    }
}

