<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Models\LevelModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;   //mengimpor validator

class LevelController extends Controller
{
    public function index()
    {
        //Menambah data
        /*DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)', ['CUS', 'Pelanggan', now()]);
        return 'Insert data baru berhasil';

        //Melakukan update data
        $row = DB::update('update m_level set level_nama = ? where level_kode = ?', ['Customer', 'CUS']);
        return 'Update data berhasil. Jumlah data yang di-update: ' . $row.' baris';

        //Menghapus data
        $row = DB::delete('delete from m_level where level_kode = ?', ['CUS']);
        return 'Delete data berhasil. Jumlah data yang dihapus: ' .$row.' baris';

        //Menampilkan data
        $data = DB::select('select * from m_level');
        return view('level', ['data' => $data]);*/

        $breadcrumb = (object) [
            'title' => 'Data Level',
            'list'  => ['Home', 'Level']
        ];
        $page = (object) [
            'title' => 'Daftar level yang terdaftar dalam sistem'
        ];
        $activeMenu = 'level';
        $level = LevelModel::all();
        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request) 
    { 
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');
        //Pengaturan Filter
        if ($request->level_kode){
            $levels->where('level_kode', $request->level_kode);
        }

        return DataTables::of($levels) 
            ->addIndexColumn()  
            ->addColumn('aksi', function ($level) { 
                $btn = '<a href="'.url('/level/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="'.url('/level/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="'.url('/level/'.$level->level_id).'">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                    //$btn = '<button onclick="modalAction(\''.url('/level/' . $level->level_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button>';
                    $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id .'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                    $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id .'/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn; 
            }) 
            ->rawColumns(['aksi'])  
            ->make(true); 
    }

    //Menambah data level AJAX
    public function create_ajax()
{
    return view('level.create_ajax');
}


    //Menyimpan data level baru AJAX
    public function store_ajax(Request $request)
{
    if ($request->ajax() || $request->wantsJson()) {
        $rules = [
            'level_kode' => 'required|string|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        LevelModel::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data level berhasil disimpan',
        ]);
    }

    return redirect('/');
}


    public function show(string $id)
    {
        $level = LevelModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list'  => ['Home', 'Level', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail Level'
        ];
        $activeMenu = 'level';
        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    // LevelController.php
public function show_ajax($id)
{
    $level = LevelModel::find($id);

    if (!$level) {
        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan!'
        ], 404);
    }

    return view('level.show_ajax', compact('level'))->render();
}

    //Menampilkan laman form edit level AJAX
    public function edit_ajax(string $id)
    {
        $level = LevelModel::find($id);

        return view('level.edit_ajax', ['level' => $level]);
    }

    //Menyimpan perubahan data level AJAX
    public function update_ajax(Request $request, $id){
        //periksa bila request dari ajax atau bukan
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|unique:m_level,level_kode',
                'level_nama' => 'required|string|max:100',
            ];

            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }

            $check = LevelModel::find($id);
            if ($check) {
                if(!$request->filled('password') ){ // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }

                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else{
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    //Menampilkan form confirm hapus data level AJAX
    public function confirm_ajax(string $id)
    {
        $level = LevelModel::find($id);
    
        if (!$level) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    
        return view('level.confirm_ajax', compact('level'));
    }
    
    // Hapus data secara langsung melalui endpoint non-AJAX (bisa dipanggil via form biasa)
    public function destroy(string $id)
    {
        $level = LevelModel::find($id);
    
        if (!$level) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
    
        $level->delete();
    
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
    
    // Hapus data menggunakan AJAX
    public function delete_ajax(Request $request, string $id)
    {
        $level = LevelModel::find($id);
    
        if (!$level) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    
        $level->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
    

}
