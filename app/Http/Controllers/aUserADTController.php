<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserADTModel;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;

class aUserADTController extends Controller
{
    public function index()
    {

        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User'],
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem',
        ];

        $activeMenu = 'aUserADT'; //set menu yang sedang active

        $level = LevelModel::all(); //ambil data level untuk filter level

        return view('aUserADT.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu]);

    }

    public function list(Request $request)
    {
        $users = UserADTModel::select('adt_id', 'username', 'nama', 'nip', 'email', 'level_id', 'avatar')
            ->with('level');

        //Filter data user berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($aUserADT) { // menambahkan kolom aksi
                /*$btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';*/
                $btn  = '<button onclick="modalAction(\'' . url('/aUserADT/' . $aUserADT->adt_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/aUserADT/' . $aUserADT->adt_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/aUserADT/' . $aUserADT->adt_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['avatar', 'aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function show_ajax(string $id)
    {
        $aUserADT = UserADTModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('aUserADT.show_ajax', ['aUserADT' => $aUserADT, 'level' => $level]);
    }
    
    public function destroy(string $id)
    {

        $check = UserADTModel::find($id);
        if (!$check) {
            return redirect('/aUserADT')->with('error', 'Data User Tidak ditemukan');
        }

        try {
            UserADTModel::destroy($id);

            return redirect('/aUserADT')->with('success', 'Data User berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            return redirect('/aUserADT')->with('error', 'Data User gagal dihapus karena masih terdapat tabel lain yang berkaitan');
        }
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('aUserADT.create_ajax')
            ->with('level', $level);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'username' => 'required|string|min:3|unique:m_useradt,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:5',
                'nip' => 'required|string|max:20',
                'email' => 'required|string|max:50',
                'level_id' => 'required|integer',
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];

            // use iluminate/support/facades/validator
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $input = $request->all();

            // Jika avatar ada, simpan gambar, jika tidak ada gunakan default
            if ($request->hasFile('avatar')) {
                $fileName = 'profile_' . Auth::aUserADT()->adt_id . '.' . $request->avatar->getClientOriginalExtension();

                // Check if an existing profile picture exists and delete it
                $oldFile = 'profile_pictures/' . $fileName;
                if (Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }

                $request->avatar->move(public_path('gambar'), $fileName);
            } else {
                $fileName = 'profil-pic.png'; // default avatar
            }

            UserADTModel::create([
                'level_id' => $input['level_id'],
                'username' => $input['username'],
                'nama' => $input['nama'],
                'password' => bcrypt($input['password']),
                'avatar' => $fileName, // Simpan nama file gambar
                'nip' => $input['nip'],
                'email' => $input['email'],
                
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data User berhasil disimpan',
            ]);

        }

        redirect('/');
    }

    public function edit_ajax(string $id)
    {

        $aUserADT = UserADTModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('aUserADT.edit_ajax', ['aUserADT' => $aUserADT, 'level' => $level]);
    }

    // Menyimpan perubahan data user dengan AJAX termasuk file gambar
    public function update_ajax(Request $request, $id)
    {
        // Periksa jika request berasal dari AJAX atau JSON
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'username' => 'required|string|min:3|unique:m_useradt,username',
                'nama' => 'required|string|max:100',
                'nip' => 'required|string|max:20',
                'email' => 'required|string|max:50',
                'level_id' => 'required|integer',
                'password' => 'nullable|min:5|max:20',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Avatar tidak wajib
            ];

            // Validator untuk validasi data yang dikirim
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // Respon JSON, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(), // Menunjukkan field mana yang error
                ]);
            }

            // Cari user berdasarkan ID
            $aUserADT = UserADTModel::find($id);
            if ($aUserADT) {
                // Jika password tidak diisi, hapus dari request agar tidak di-update
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }

                if (!$request->filled('avatar')) {
                    $request->request->remove('avatar');
                }

                // Cek jika ada file avatar yang diunggah
                if ($request->hasFile('avatar')) {
                    // Dapatkan file avatar
                    $file = $request->file('avatar');
                    // Buat nama unik untuk file avatar tersebut
                    $filename = 'profile_' . Auth::aUserADT()->adt_id . '.' . $request->avatar->getClientOriginalExtension();
                    // Tentukan path penyimpanan
                    $path = public_path('gambar');
                    // Simpan file di direktori 'gambar'
                    $file->move($path, $filename);

                    // Simpan nama file avatar baru di database
                    $aUserADT->avatar = $filename;
                }

                // Update data user kecuali avatar (avatar sudah di-handle di atas)
                $aUserADT->update($request->except('avatar'));

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $aUserADT = UserADTModel::find($id);

        return view('aUserADT.confirm_ajax', ['aUserADT' => $aUserADT]);
    }

    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserADTModel::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }
}