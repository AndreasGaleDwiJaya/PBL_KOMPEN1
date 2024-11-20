<?php

namespace App\Http\Controllers;

use App\Models\DaftarMhsAlphaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class aDMAlphaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Mahasiswa Alpha',
            'list' => ['Home', 'Daftar Mahasiswa Alpha']
        ];

        $page = (object)[
            'title' => 'Daftar Mahasiswa Alpha'
        ];

        $activeMenu = 'aDMAlpha';

        return view('aDMAlpha.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
{
    $mhsalpha = DaftarMhsAlphaModel::with('mahasiswa')
        ->select('daftarmhsalpha_id', 'mahasiswa_id', 'jumlah_jamalpha', 'periode', 'prodi')
        ->get(); // Pastikan data sudah diambil

    return DataTables::of($mhsalpha)
        ->addIndexColumn()
        ->addColumn('nama_mahasiswa', function ($data) {
            return $data->mahasiswa ? $data->mahasiswa->nama : '-';
        })
        ->rawColumns(['nama_mahasiswa'])
        ->make(true);
}



}
