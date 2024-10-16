<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index($id)
    {
        $kategori = DB::table('kategori')->where('id', $id)->first();
        $data = [
            'title' => 'Kategori',
            'id'=> $id,
            'nm_kategori'=> $kategori->kategori,
        ];
        return view('kategori', $data);
    }

    public function getAset($id): JsonResponse
    {

        $perPage = 6;
        $data = DB::table('aset')
            ->select(
                'aset.id as id_aset',
                'aset.nib_aset',
                'aset.nama_aset',
                'aset.id_kategori',
                'aset.deskripsi',
                'aset.status',
                'aset.img',
                'aset.created_at',
                'aset.updated_at',
                'aset.id_unit',
                'kategori.id as kategori_id',
                'kategori.kategori',
                'tbl_unit.id as unit_id',
                'tbl_unit.nm_unit',
                'tbl_unit.pimpinan',
                'tbl_unit.nip_pimpinan',
                'tbl_unit.gol',
                'tbl_unit.jabatan',

                'tbl_unit.created_at as unit_created_at',
                'tbl_unit.updated_at as unit_updated_at',

            )
            ->join('kategori', 'aset.id_kategori', '=', 'kategori.id')
            ->join('tbl_unit', 'aset.id_unit', '=', 'tbl_unit.id')
            ->where('aset.id_kategori', $id)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);


        if ($data->isNotEmpty()) {
            return response()->json($data, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
    }
}
