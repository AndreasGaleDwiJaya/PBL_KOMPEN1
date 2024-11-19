<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\UserMahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;

class aUserMahasiswaController extends Controller
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

        $activeMenu = 'aUserMahasiswa'; //set menu yang sedang active

        $level = LevelModel::all(); //ambil data level untuk filter level

        return view('aUserMahasiswa.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu]);

    }

    public function list(Request $request)
    {
        $users = UserMahasiswaModel::select('mahasiswa_id', 'username', 'nama', 'nim', 'email', 'level_id', 'avatar')
            ->with('level');

        //Filter data user berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
        // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->editColumn('avatar', function ($user) {
                return '<img src="' . asset('gambar/' . $user->avatar) . '"  style="width: 70px; height: 70px;" />';
            })
            ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
                /*$btn = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
            $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
            $btn .= '<form class="d-inline-block" method="POST" action="'.url('/user/'.$user->user_id).'">'
            . csrf_field() . method_field('DELETE') .
            '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';*/
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->mahasiswa_id . '/') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->mahasiswa_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->mahasiswa_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['avatar', 'aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {

        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah User Baru',
        ];

        $level = LevelModel::all(); //ambil data level untuk ditampilkan di form

        $activeMenu = 'user'; //set menu yang sedang aktif

        return view('user.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu,
        ]);
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                // username harus diisi, berupa string, min 3 karakter, dan bernilai unik di tabel m_user kolom username
                'username' => 'required|string|min:3|unique:m_usermahasiswa,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:5',
                'level_id' => 'required|integer',
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'nim' => 'required|string|max:20',
                'email' => 'required|string|max:50',
            ]
        );

        UserMahasiswaModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password,
            'level_id' => $request->level_id,
            'nim' => $request->nim,
            'email' => $request->email,
        ]);

        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }

    public function show(string $id)
    {

        $user = UserMahasiswaModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Detail User',
        ];

        $activeMenu = 'user'; //set menu yang sedang aktif

        return view('user.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu,
        ]);

    }

    public function edit(string $id)
    {

        $user = UserMahasiswaModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit'],
        ];

        $page = (object) [
            'title' => 'Edit User',
        ];

        $activeMenu = 'user'; //set menu yang sedang aktif

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'user' => $user,
            'activeMenu' => $activeMenu,
        ]);
    }

    public function update(Request $request, string $id)
    {

        $request->validate(
            [
                // username harus diisi, berupa string, min 3 karakter, dan bernilai unik di tabel m_user kolom username
                'username' => 'required|string|min:3|unique:m_usermahasiswa,username,' . $id . ',user_id',
                'nama' => 'required|string|max:100',
                'password' => 'nullable|min:5',
                'level_id' => 'required|integer',
                'nim' => 'required|string|max:20',
                'email' => 'required|string|max:50',
            ]
        );

        UserMahasiswaModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserMahasiswaModel::find($id)->password,
            'level_id' => $request->level_id,
            'nim' => $request->nim,
            'email' => $request->email,
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    public function destroy(string $id)
    {

        $check = UserMahasiswaModel::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data User Tidak ditemukan');
        }

        try {
            UserMahasiswaModel::destroy($id);

            return redirect('/user')->with('success', 'Data User berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            return redirect('/user')->with('error', 'Data User gagal dihapus karena masih terdapat tabel lain yang berkaitan');
        }
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.create_ajax')
            ->with('level', $level);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:5',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'nim' => 'required|string|max:20',
                'email' => 'required|string|max:50',
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
                $fileName = 'profile_' . Auth::user()->user_id . '.' . $request->avatar->getClientOriginalExtension();

                // Check if an existing profile picture exists and delete it
                $oldFile = 'profile_pictures/' . $fileName;
                if (Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }

                $request->avatar->move(public_path('gambar'), $fileName);
            } else {
                $fileName = 'profil-pic.png'; // default avatar
            }

            UserMahasiswaModel::create([
                'level_id' => $input['level_id'],
                'username' => $input['username'],
                'nama' => $input['nama'],
                'password' => bcrypt($input['password']),
                'avatar' => $fileName, // Simpan nama file gambar
                'nim' => $input['nim'],
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

        $user = UserMahasiswaModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    // Menyimpan perubahan data user dengan AJAX termasuk file gambar
    public function update_ajax(Request $request, $id)
    {
        // Periksa jika request berasal dari AJAX atau JSON
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:5|max:20',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Avatar tidak wajib
                'nim' => 'required|string|max:20',
                'email' => 'required|string|max:50',
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
            $user = UserMahasiswaModel::find($id);
            if ($user) {
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
                    $filename = 'profile_' . Auth::user()->user_id . '.' . $request->avatar->getClientOriginalExtension();
                    // Tentukan path penyimpanan
                    $path = public_path('gambar');
                    // Simpan file di direktori 'gambar'
                    $file->move($path, $filename);

                    // Simpan nama file avatar baru di database
                    $user->avatar = $filename;
                }

                // Update data user kecuali avatar (avatar sudah di-handle di atas)
                $user->update($request->except('avatar'));

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
        $user = UserMahasiswaModel::find($id);

        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
    {
        //cek apakah request dari AJAX
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserMahasiswaModel::find($id);
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

//     public function import()
//     {
//         return view('user.import');
//     }
//     public function import_ajax(Request $request)
//     {
//         if ($request->ajax() || $request->wantsJson()) {
//             $rules = [
// // validasi file harus xls atau xlsx, max 1MB
//                 'file_user' => ['required', 'mimes:xlsx', 'max:1024'],
//             ];
//             $validator = Validator::make($request->all(), $rules);
//             if ($validator->fails()) {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Validasi Gagal',
//                     'msgField' => $validator->errors(),
//                 ]);
//             }
//             $file = $request->file('file_user'); // ambil file dari request
//             $reader = IOFactory::createReader('Xlsx'); // load reader file excel
//             $reader->setReadDataOnly(true); // hanya membaca data
//             $spreadsheet = $reader->load($file->getRealPath()); // load file excel
//             $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
//             $data = $sheet->toArray(null, false, true, true); // ambil data excel
//             $insert = [];
//             if (count($data) > 1) { // jika data lebih dari 1 baris
//                 foreach ($data as $baris => $value) {
//                     if ($baris > 1) { // baris ke 1 adalah header, maka lewati
//                         $insert[] = [
//                             'level_id' => $value['A'],
//                             'username' => $value['B'],
//                             'nama' => $value['C'],
//                             'password' => $value['D'],
//                             'created_at' => now(),
//                         ];
//                     }
//                 }
//                 if (count($insert) > 0) {
//             // insert data ke database, jika data sudah ada, maka diabaikan
//                     UserModel::insertOrIgnore($insert);
//                 }
//                 return response()->json([
//                     'status' => true,
//                     'message' => 'Data berhasil diimport',
//                 ]);
//             } else {
//                 return response()->json([
//                     'status' => false,
//                     'message' => 'Tidak ada data yang diimport',
//                 ]);
//             }
//         }
//         return redirect('/');
//     }

//     public function export_excel()
//     {
//         //ambil data yang akan di export
//         $user = UserModel::select('level_id', 'user_id', 'nama','username', 'password')
//             ->orderBy('level_id')
//             ->with('level')
//             ->get();

//         //load library
//         $spreadsheet = new Spreadsheet();
//         $sheet = $spreadsheet->getActiveSheet();

//         $sheet->setCellValue('A1', 'No');
//         $sheet->setCellValue('B1', 'Username');
//         $sheet->setCellValue('C1', 'Nama Pengguna');
//         $sheet->setCellValue('D1', 'Level Pengguna');

//         $sheet->getStyle('A1:D1')->getFont()->setBold(true); //bold header

//         $no = 1;
//         $baris = 2;
//         foreach ($user as $key => $value) {
//             $sheet->setCellValue('A' . $baris, $no);
//             $sheet->setCellValue('B' . $baris, $value->username);
//             $sheet->setCellValue('C' . $baris, $value->nama);
//             $sheet->setCellValue('D' . $baris, $value->level->level_nama);
//             $baris++;
//             $no++;

//         }

//         foreach (range('A', 'D') as $columID) {
//             $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
//         }

//         $sheet->setTitle('Data User');
//         $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
//         $filename = 'Data User ' . date('Y-m-d H:i:s') . '.xlsx';
//         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//         header('Content-Disposition: attachment;filename="' . $filename . '"');
//         header('Cache-Control: max-age=0');
//         header('Cache-Control: max-age=1');
//         header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//         header('Last-Modified: ' . gmdate('D, dMY H:i:s') . 'GMT');
//         header('Cache-Control: cache, must-revalidate');
//         header('Pragma: public');
//         $writer->save('php://output');
//         exit;

//     }

//     public function export_pdf(){
//         //ambil data yang akan di export
//         set_time_limit(120); 
//         $user = UserModel::select('level_id', 'user_id', 'username', 'nama','password')
//         ->orderBy('level_id')
//         ->with('level')
//         ->get();

//         //use Barruvdh\DomPDF\Facade\\Pdf
//        $pdf = Pdf::loadView('user.export_pdf', ['user' =>$user]);
//        $pdf->setPaper('a4', 'potrait');
//        $pdf->setOption("isRemoteEnabled", true);
//        $pdf->render();

//        return $pdf->download('Data User '.date('Y-m-d H:i:s').'.pdf');
//    }


}