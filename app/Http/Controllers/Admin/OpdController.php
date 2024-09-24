<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class OpdController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Kelola OPD'
        ];
        return view('admin/opd', $data);
    }

    public function getDatatablesOpd()
    {
        $data = DB::table('tbl_unit')

            ->orderBy('tbl_unit.id', 'ASC')
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
                'nm_unit' => 'required',
            ],
            [
                'nm_unit.required' => 'Kolom opd unit wajib diisi.',
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
            DB::table('tbl_unit')->insert($validatedData);
            return response()->json(['success' => true, 'message' => 'Success'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed'], 500);
        }
    }

    public function destroy($id)
    {
        $product = DB::table('tbl_unit')->find($id);
    
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'OPD tidak ditemukan'], 404); // 404: Not Found
        }
    
        try {
            DB::table('tbl_unit')->where('id', $id)->delete();
    
            return response()->json(['success' => true, 'message' => 'OPD berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus produk'], 500); // 500: Internal Server Error
        }
    }
}
