<?php

namespace App\Http\Controllers;

use App\Models\BidKomModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class aManageBidKomController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Manage Bidang Kompetensi',
            'list' => ['Home', 'Manage Bidang Kompetensi']
        ];

        $page = (object)[
            'title' => 'Manage Bidang Kompetensi'
        ];

        $activeMenu = 'aManageBidKom';

        return view('aManageBidKom.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $bidkom = BidKomModel::select('bidkom_id', 'nama_bidkom');

        return DataTables::of($bidkom)
            ->addIndexColumn()
            ->addColumn('aksi', function ($bidkom) {
                $btn  = '<button onclick="modalAction(\'' . route('bidangKompetensi.show_ajax', $bidkom->bidkom_id) . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . route('bidangKompetensi.edit_ajax', $bidkom->bidkom_id) . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . route('bidangKompetensi.delete_ajax', $bidkom->bidkom_id) . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // public function show_ajax($id)
    // {
    //     $bidkom = BidKomModel::find($id);

    //     if (!$bidkom) {
    //         abort(404, 'Data tidak ditemukan');
    //     }

    //     return view('aManageBidKom.show_ajax', compact('bidkom'));
    // }

    public function create_ajax()
{
    return view('aManageBidKom.create_ajax');
}

public function store_ajax(Request $request)
{
    // Validasi input
    $request->validate([
        'nama_bidkom' => 'required|string|max:255'
    ]);

    try {
        // Simpan data ke database
        BidKomModel::create([
            'nama_bidkom' => $request->nama_bidkom
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
    }
}

public function edit_ajax($id)
{
    $bidKom = BidKomModel::find($id);

    if (!$bidKom) {
        return response()->json(['error' => 'Data tidak ditemukan.'], 404);
    }

    return view('aManageBidKom.edit_ajax', compact('bidKom'));
}

public function update_ajax(Request $request, $id)
{
    $request->validate([
        'nama_bidkom' => 'required|string|max:255',
    ]);

    $bidKom = BidKomModel::find($id);

    if (!$bidKom) {
        return response()->json(['error' => 'Data tidak ditemukan.'], 404);
    }

    $bidKom->update([
        'nama_bidkom' => $request->nama_bidkom,
    ]);

    return response()->json(['success' => 'Data berhasil diperbarui.']);
}

public function show_ajax($id)
{
    $bidKom = BidKomModel::find($id);
    if (!$bidKom) {
        return redirect()->route('aManageBidKom.index')->with('error', 'Data tidak ditemukan.');
    }

    return view('aManageBidKom.show_ajax', compact('bidKom'));
}

// Menghapus data bidang kompetensi
// Method untuk menangani penghapusan data
// Method untuk menampilkan form konfirmasi penghapusan
public function delete_ajax($id)
{
    $bidKom = BidKomModel::find($id);

    if (!$bidKom) {
        return response()->json(['error' => 'Data tidak ditemukan.'], 404);
    }

    return view('aManageBidKom.confirm_ajax', compact('bidKom'));
}

// Method untuk melakukan penghapusan data
public function destroy($id)
{
    $bidKom = BidKomModel::find($id);

    if (!$bidKom) {
        return response()->json(['error' => 'Data tidak ditemukan.'], 404);
    }

    $bidKom->delete();

    return response()->json(['success' => 'Data berhasil dihapus.']);
}

// Method untuk menangani AJAX konfirmasi
public function confirm_ajax($id)
{
    $bidKom = BidKomModel::find($id);

    if (!$bidKom) {
        return response()->json(['error' => 'Data tidak ditemukan.'], 404);
    }

    // Kembalikan data untuk konfirmasi penghapusan
    return response()->json([
        'success' => true,
        'nama_bidkom' => $bidKom->nama_bidkom,
        'id' => $bidKom->bidkom_id,
    ]);
}
    

    // Tambahkan fungsi lainnya seperti create, edit, delete jika diperlukan
}

