<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class PermohonanController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Permohonan Aset'
        ];
        return view('admin/permohonan', $data);
    }

    public function getDataAsetId($id): JsonResponse
    {
        $data = DB::table('aset')
            ->where('id', $id)->first();

        if ($data) {
            return response()->json($data, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function permohonanDetail($id)
    {
        $aset = DB::table('aset')
            ->select(
                'aset.id',
                'aset.nib_aset',
                'aset.nama_aset',
                'aset.deskripsi',
                'aset.img',
                'aset.id_mohon',
                'aset.created_at',
                'aset.updated_at',
                'aset.id_unit',
                'aset.status',
                'kategori.kategori',
                'tbl_unit.nm_unit'
            )
            ->where('aset.id', $id)->join('kategori', 'aset.id_kategori', '=', 'kategori.id')
            ->join('tbl_unit', 'aset.id_unit', '=', 'tbl_unit.id')->first();

        $data = [
            'title' => 'Detail Permohonan',
            'aset' => $aset
        ];
        return view('admin/permohonan_detail', $data);
    }

    public function getAsetDatatable(Request $request)
    {
        $status = $request->input('status'); // Ambil nilai status dari request
        $query = DB::table('aset')
            ->select(
                'aset.id as id',
                'aset.nib_aset',
                'aset.nama_aset',
                'aset.id_kategori',
                'aset.deskripsi',
                'aset.status',
                'aset.img',
                'aset.created_at',
                'aset.updated_at',
                'aset.id_unit',
                'aset.jml_mohon',
                'tbl_unit.nm_unit',
                'tbl_unit.pimpinan',
                'tbl_unit.nip_pimpinan',
                'tbl_unit.gol',
                'tbl_unit.jabatan',
                'kategori.kategori',
            )
            ->whereNot('aset.jml_mohon', 0)
            ->join('tbl_unit', 'aset.id_unit', '=', 'tbl_unit.id')
            ->join('kategori', 'aset.id_kategori', '=', 'kategori.id')
            // ->where('table.id', $where)
            ->orderBy('aset.id', 'ASC');
        //Gunakan kondisi sesuai role login
        //->when(auth()->user()->role === 'role', function (query) {
        //return query->where('table.role', session('role'));
        //})
        if (!is_null($status) && $status !== '') {
            $query->where('aset.status', $status);
        }

        // Gunakan kondisi sesuai role login
        $query->when(auth()->user()->role === 'opd', function ($query) {
            return $query->where('aset.id_unit', session('id_unit'));
        });

        $data = $query->get();

        return DataTables::of($data)

            ->make(true);
    }




    public function getAsetMohon($id)
    {
        $query = DB::table('tbl_mohon')
            ->select(

                'tbl_mohon.id as id_mohon',
                'tbl_mohon.id as id_aset',
                'tbl_mohon.catatan',
                'tbl_mohon.srt_mohon',
                'tbl_mohon.tgl_mulai',
                'tbl_mohon.tgl_akhir',
                'tbl_mohon.created_at',
                'tbl_mohon.status',

                'users.name'
            )

            ->join('users', 'tbl_mohon.id_user', '=', 'users.id', 'left')

            ->where('tbl_mohon.id_aset', $id)
            ->where('tbl_mohon.status', 0)
            ->orderBy('tbl_mohon.created_at', 'ASC');
        // Gunakan kondisi sesuai role login
        // $query->when(auth()->user()->role === 'opd', function ($query) {
        //     return $query->where('aset.id_unit', session('id_unit'));
        // });

        $data = $query->get();

        return DataTables::of($data)
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getAsetMohonFinish($id)
    {
        $query = DB::table('tbl_mohon')
            ->select(

                'tbl_mohon.id as id_mohon',
                'tbl_mohon.id as id_aset',
                'tbl_mohon.catatan',
                'tbl_mohon.srt_mohon',
                'tbl_mohon.tgl_mulai',
                'tbl_mohon.tgl_akhir',
                'tbl_mohon.created_at',
                'tbl_mohon.status',
                'tbl_mohon.tgl_mulai_accept',
                'tbl_mohon.tgl_akhir_accept',
                'tbl_mohon.jam_mulai_accept',
                'tbl_mohon.jam_akhir_accept',

                'users.name'
            )

            ->join('users', 'tbl_mohon.id_user', '=', 'users.id', 'left')

            ->where('tbl_mohon.id_aset', $id)
            ->where('tbl_mohon.status', 2)
            ->orderBy('tbl_mohon.created_at', 'ASC');
        //Gunakan kondisi sesuai role login
        //->when(auth()->user()->role === 'role', function ($query) {
        //return $query->where('table.role', session('role'));
        //})
        // Gunakan kondisi sesuai role login
        // $query->when(auth()->user()->role === 'opd', function ($query) {
        //     return $query->where('aset.id_unit', session('id_unit'));
        // });

        $data = $query->get();
        return DataTables::of($data)
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getDataMohon($id): JsonResponse
    {
        $data = DB::table('tbl_mohon')->select(
            'tbl_mohon.id as id_mohon',
            'tbl_mohon.id_aset',
            'tbl_mohon.catatan',
            'tbl_mohon.srt_mohon',
            'tbl_mohon.tgl_mulai',
            'tbl_mohon.jam_mulai',
            'tbl_mohon.tgl_akhir',
            'tbl_mohon.jam_akhir',
            'tbl_mohon.created_at',
            'tbl_mohon.status',

            'users.name'
        )
            ->join('users', 'tbl_mohon.id_user', '=', 'users.id', 'left')
            ->where('tbl_mohon.id', $id)->first();

        if ($data) {
            // Mengambil tanggal dan waktu dari tgl_mulai
            $data->jam_mulai = Carbon::parse($data->jam_mulai)->format('H:i');
            $data->jam_akhir = Carbon::parse($data->jam_akhir)->format('H:i');

            return response()->json($data, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Tidak ditemukan'], Response::HTTP_NOT_FOUND);
        }
    }



    public function update(Request $request)
    {
        $id_aset_select = $request->input('id_aset_select');
        $id_mohon_select = $request->input('id_mohon_select');
        $jadwal_mulai = $request->input('jadwal_mulai');
        $jadwal_mulai_time = $request->input('jadwal_mulai_time');
        $jadwal_akhir = $request->input('jadwal_akhir');
        $jadwal_akhir_time = $request->input('jadwal_akhir_time');
        $reschedule = $request->input('reschedule');

        $aset = DB::table('aset')->where('id', $id_aset_select)->first();

        if ($aset->status == 1) {
            return response()->json(['success' => false, 'message' => 'Aset telah dipinjam']); // 404: Not Found
        }

        try {
            DB::table('aset')
                ->where('id', $id_aset_select)
                ->update([
                    'id_mohon' => $id_mohon_select,
                    'jml_mohon' => DB::raw('jml_mohon - 1'),
                    'mulai_date' => $jadwal_mulai,
                    'akhir_date' => $jadwal_akhir,
                    'mulai_time' => $jadwal_mulai_time,
                    'akhir_time' => $jadwal_akhir_time,
                    'status' => 1,
                    'reschedule' => $reschedule,
                ]);

            DB::table('tbl_mohon')
                ->where('id', $id_mohon_select)
                ->update([

                    'status' => 1,
                    'tgl_mulai_accept' => $jadwal_mulai,
                    'tgl_akhir_accept' => $jadwal_akhir,
                    'jam_mulai_accept' => $jadwal_mulai_time,
                    'jam_akhir_accept' => $jadwal_akhir_time,
                    'reschedule_mohon' => $reschedule,
                ]);
            return response()->json(['success' => true, 'message' => 'Aset berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui Aset. Error: ' . $e->getMessage()]);
        }
    }

    public function finishAset($id_aset, $id_mohon)
    {
        $aset = DB::table('aset')->find($id_aset);


        if (!$aset) {
            return response()->json(['success' => false, 'message' => 'Aset tidak ditemukan'], 404); // 404: Not Found
        }

        try {
            DB::table('aset')->where('id', $id_aset)->update([
                'status' => 0,
                'id_mohon' => null,
                'mulai_date' => null,
                'akhir_date' => null,
                'reschedule' => 0,
                'mulai_time' => null,
                'akhir_time' => null,
            ]);
            DB::table('tbl_mohon')->where('id', $id_mohon)->update([
                'status' => 2,

            ]);

            return response()->json(['success' => true, 'message' => 'Aset berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus Aset'], 500); // 500: Internal Server Error
        }
    }
    public function getAsetMohonFinishAll()
    {
        $data = [
            'title' => 'Permohonan Selesai'
        ];
        return view('admin/permohonan_finish', $data);
    }

    public function getAsetMohonFinishAllData()
    {
        $query = DB::table('tbl_mohon')
            ->select(

                'tbl_mohon.id as id_mohon',
                'tbl_mohon.id as id_aset',
                'tbl_mohon.catatan',
                'tbl_mohon.srt_mohon',
                'tbl_mohon.tgl_mulai',
                'tbl_mohon.tgl_akhir',
                'tbl_mohon.jam_mulai',
                'tbl_mohon.jam_akhir',
                'tbl_mohon.created_at',
                'tbl_mohon.status',
                'tbl_mohon.tgl_mulai_accept',
                'tbl_mohon.tgl_akhir_accept',
                'tbl_mohon.jam_mulai_accept',
                'tbl_mohon.jam_akhir_accept',
                'tbl_mohon.reschedule_mohon',
                'users.name',
                'aset.id as id',
                'aset.nib_aset',
                'aset.nama_aset',
                'aset.id_kategori',
                'aset.id_mohon',
                'aset.deskripsi',
                'aset.status',
                'aset.img',
                'aset.created_at',
                'aset.updated_at',
                'aset.mulai_date',
                'aset.mulai_time',
                'aset.akhir_date',
                'aset.akhir_time',
                'aset.reschedule',
            )

            ->join('users', 'tbl_mohon.id_user', '=', 'users.id', 'left')
            ->join('aset', 'tbl_mohon.id_aset', '=', 'aset.id', 'left')


            ->where('tbl_mohon.status', 2)
            ->orderBy('tbl_mohon.created_at', 'ASC');
        // Gunakan kondisi sesuai role login
        // $query->when(auth()->user()->role === 'opd', function ($query) {
        //     return $query->where('aset.id_unit', session('id_unit'));
        // });

        $data = $query->get();

        return DataTables::of($data)
            ->rawColumns(['action'])
            ->make(true);
    }
}
