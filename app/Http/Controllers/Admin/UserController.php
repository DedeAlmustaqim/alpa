<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function adminOpd()
    {
        $unit = DB::table('tbl_unit')->get();
        $data = [
            'title' => 'Admin OPD',
            'unit' => $unit,
        ];
        return view('admin/admin_opd', $data);
    }

    public function user()
    {
        $data = [
            'title' => 'User'
        ];
        return view('admin/user', $data);
    }
    public function getDatatablesUser()
    {
        $data = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.role',
                'users.no_hp',
                'users.nip',
                'users.active',

            )

            ->where('role', 'pengguna')
            ->orderBy('users.id', 'ASC')
            //Gunakan kondisi sesuai role login
            //->when(auth()->user()->role === 'role', function ($query) {
            //return $query->where('table.role', session('role'));
            //})
            ->get();
        return DataTables::of($data)
            ->rawColumns(['action'])
            ->make(true);
    }


    public function getDatatablesAdminOpd()
    {
        $data = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.role',
                'users.no_hp',
                'users.nip',
                'users.id_unit',
                'tbl_unit.nm_unit',
            )
            ->join('tbl_unit', 'users.id_unit', '=', 'tbl_unit.id')
            ->whereIn('role', ['opd', 'verifikator']) // Menggunakan whereIn
            ->orderBy('users.id', 'ASC')
            //Gunakan kondisi sesuai role login
            //->when(auth()->user()->role === 'role', function ($query) {
            //return $query->where('table.role', session('role'));
            //})
            ->get();
        return DataTables::of($data)
            ->rawColumns(['action'])
            ->make(true);
    }

    public function storeAdminOpd(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id_unit_admin' => 'required',
                'nama_admin' => 'required',
                'role' => 'required',
                'email_admin' => 'required|email|unique:users,email', // Email harus unik
                'no_hp_admin' => 'required|unique:users,no_hp', // No HP harus unik
                'password_admin' => 'required',
            ],
            [
                'id_unit_admin.required' => 'Kolom wajib diisi.',
                'nama_admin.required' => 'Kolom wajib diisi.',
                'role.required' => 'Kolom wajib diisi.',
                'email_admin.required' => 'Kolom wajib diisi.',
                'email_admin.email' => 'Format email tidak valid.',
                'email_admin.unique' => 'Email sudah digunakan.', // Pesan untuk email yang tidak unik
                'no_hp_admin.required' => 'Kolom wajib diisi.',
                'no_hp_admin.unique' => 'Nomor HP sudah digunakan.', // Pesan untuk no_hp yang tidak unik
                'password_admin.required' => 'Kolom wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all() // Ambil semua error sebagai array
            ]); // 422: Unprocessable Entity
        }


        $id_unit = $request->input('id_unit_admin');
        $nama_admin = $request->input('nama_admin');
        $email_admin = $request->input('email_admin');
        $no_hp_admin = $request->input('no_hp_admin');
        $role = $request->input('role');
        $password_admin = $request->input('password_admin');

        //Custome Array
        //if (array_key_exists('input_name', $validatedData)) {
        // $validatedData['input_name'] =  .... ;
        //}
        try {
            DB::table('users')->insert(
                [
                    'name' => $nama_admin,
                    'id_unit' => $id_unit,
                    'email' => $email_admin,
                    'no_hp' => $no_hp_admin,
                    'role' => $role,
                    'password' => Hash::make($password_admin), // Enkripsi password
                ]
            );
            return response()->json(['success' => true, 'message' => 'Success'],);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed'],);
        }
    }

    public function destroy($id)
    {
        $product = DB::table('users')->find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404); // 404: Not Found
        }

        try {
            DB::table('users')->where('id', $id)->delete();

            return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus produk'], 500); // 500: Internal Server Error
        }
    }

    public function updateStatus($id, $status)
    {


        $data = DB::table('users')->find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404); // 404: Not Found
        }

        try {
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'active' => $status,
                ]);

            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui produk'], 500); // 500: Internal Server Error
        }
    }
    
}
