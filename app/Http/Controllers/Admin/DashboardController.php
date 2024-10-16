<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Query untuk menghitung aset berdasarkan status
        $counts = DB::table('aset')
            ->select('status', DB::raw('count(*) as total'))
            ->whereIn('status', [0, 1])
            ->when(auth()->user()->role === 'opd', function ($query) {
                return $query->where('id_unit', session('id_unit'));
            })
            ->when(auth()->user()->role === 'verifikator', function ($query) {
                // Gantilah kondisi ini dengan yang sesuai untuk verifikator
                return $query->where('aset.id_unit', session('id_unit'));
            })
            ->groupBy('status')
            ->get();

        // Hitung total seluruh aset
        $totalAset = DB::table('aset')
            ->when(auth()->user()->role === 'opd', function ($query) {
                return $query->where('id_unit', session('id_unit'));
            })
            ->count();

        // Ambil jumlah status dari hasil query atau 0 jika tidak ada
        $countStatus0 = $counts->where('status', 0)->first()->total ?? 0;
        $countStatus1 = $counts->where('status', 1)->first()->total ?? 0;

        // Query untuk menghitung mohon berdasarkan status
        $countsMohon = DB::table('tbl_mohon')
            ->join('aset', 'aset.id', '=', 'tbl_mohon.id_aset', 'left')
            ->select('tbl_mohon.status', DB::raw('count(*) as total'))
            ->whereIn('tbl_mohon.status', [0, 1, 2, 3])
            ->when(auth()->user()->role === 'opd', function ($query) {
                return $query->where('id_unit', session('id_unit'));
            })
            ->when(auth()->user()->role === 'verifikator', function ($query) {
                // Gantilah kondisi ini dengan yang sesuai untuk verifikator
                return $query->where('aset.id_unit', session('id_unit'));
            })
            ->groupBy('tbl_mohon.status')
            ->get();

        // Hitung total seluruh mohon
        $totalMohon = DB::table('tbl_mohon')
            ->join('aset', 'aset.id', '=', 'tbl_mohon.id_aset', 'left')
            ->when(auth()->user()->role === 'opd', function ($query) {
                return $query->where('id_unit', session('id_unit'));
            })
            ->count();

        // Ambil jumlah status dari hasil query atau 0 jika tidak ada
        $countMohon0 = $countsMohon->where('status', 0)->first()->total ?? 0;
        $countMohon1 = $countsMohon->where('status', 1)->first()->total ?? 0;
        $countMohon2 = $countsMohon->where('status', 2)->first()->total ?? 0;
        $countMohon3 = $countsMohon->where('status', 3)->first()->total ?? 0;

        // Data untuk dikirim ke view
        $data = [
            'title' => 'Dashboard Admin',
            'countStatus0' => $countStatus0,
            'countStatus1' => $countStatus1,
            'totalAset' => $totalAset,
            'countMohon0' => $countMohon0,
            'countMohon1' => $countMohon1,
            'countMohon2' => $countMohon2,
            'countMohon3' => $countMohon3,
            'totalMohon' => $totalMohon,
        ];

        return view('admin/dashboard', $data);
    }
}
