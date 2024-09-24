<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kategori'
        ];
        return view('admin/kategori', $data);
    }

    public function getDatatablesKategori()
    {
        $data = DB::table('kategori')

            ->orderBy('kategori.id', 'ASC')
            //Gunakan kondisi sesuai role login
            //->when(auth()->user()->role === 'role', function ($query) {
            //return $query->where('table.role', session('role'));
            //})
            ->get();
        return DataTables::of($data)
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kategori' => 'required',
            ],
            [
                'kategori.required' => 'Kolom Nama unit wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        $validatedData = $validator->validated();

        //Custome Array
        //if (array_key_exists('input_name', $validatedData)) {
        // $validatedData['input_name'] =  .... ;
        //}
        try {
            DB::table('kategori')->insert($validatedData);
            return response()->json(['success' => true, 'message' => 'Success'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed'], 500);
        }
    }

    public function destroy($id)
    {
        $product = DB::table('kategori')->find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan'], 404); // 404: Not Found
        }

        try {
            DB::table('kategori')->where('id', $id)->delete();

            return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus produk'], 500); // 500: Internal Server Error
        }
    }

    public function update(Request $request)
    {
        $id = $request->input('id_kategori');
        $kategori_edit = $request->input('kategori_edit');

        $data = DB::table('kategori')->find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan']); // 404: Not Found
        }

        try {
            DB::table('kategori')
                ->where('id', $id)
                ->update([
                    'kategori' => $kategori_edit,
                ]);

            return response()->json(['success' => true, 'message' => 'Kategori berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui produk']); // 500: Internal Server Error
        }
    }
}
