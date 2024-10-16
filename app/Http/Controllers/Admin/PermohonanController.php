<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;
use Yajra\DataTables\Facades\DataTables;



/* Status Permohonan 

sedang dimohon = 0
sedang dipinjam = 1
selesai = 2
verifikasi = 3

*/

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
            ->when(auth()->user()->role === 'opd' || auth()->user()->role === 'verifikator', function ($query) {
                return $query->where('aset.id_unit', session('id_unit'));
            })
            ->orderBy('aset.id', 'ASC');
        //Gunakan kondisi sesuai role login
        //->when(auth()->user()->role === 'role', function (query) {
        //return query->where('table.role', session('role'));
        //})
        if (!is_null($status) && $status !== '') {
            $query->where('aset.status', $status);
        }

        // // Gunakan kondisi sesuai role login
        // $query->when(auth()->user()->role === 'opd', function ($query) {
        //     return $query->where('aset.id_unit', session('id_unit'));
        // });

        $data = $query->get();

        return DataTables::of($data)

            ->make(true);
    }




    public function getAsetMohon($id)
    {
        $query = DB::table('tbl_mohon')
            ->select(

                'tbl_mohon.id as id_mohon',
                'tbl_mohon.id_aset as id_aset',
                'tbl_mohon.catatan',
                'tbl_mohon.srt_mohon',
                'tbl_mohon.tgl_mulai',
                'tbl_mohon.tgl_akhir',
                'tbl_mohon.created_at',
                'tbl_mohon.status',

                'users.name'
            )

            ->join('users', 'tbl_mohon.id_user', '=', 'users.id', 'left')
            ->join('aset', 'aset.id', '=', 'tbl_mohon.id_aset', 'left')
            ->when(auth()->user()->role === 'opd' || auth()->user()->role === 'verifikator', function ($query) {
                return $query->where('aset.id_unit', session('id_unit'));
            })
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

    public function getAsetMohonVerif($id)
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
                'tbl_mohon.tgl_mulai_accept',
                'tbl_mohon.tgl_akhir_accept',
                'tbl_mohon.jam_mulai_accept',
                'tbl_mohon.jam_akhir_accept',
                'tbl_mohon.created_at',
                'tbl_mohon.status',
                // Memisahkan date_verif menjadi tanggal dan waktu
                DB::raw('DATE(tbl_mohon.date_verif) as date_verif_date'),
                DB::raw('TIME(tbl_mohon.date_verif) as date_verif_time'),
                'users.name'
            )

            ->join('users', 'tbl_mohon.id_user', '=', 'users.id', 'left')
            ->join('aset', 'aset.id', '=', 'tbl_mohon.id_aset', 'left')
            ->when(auth()->user()->role === 'opd' || auth()->user()->role === 'verifikator', function ($query) {
                return $query->where('aset.id_unit', session('id_unit'));
            })
            ->where('tbl_mohon.id_aset', $id)
            ->where('tbl_mohon.status', 1)
          
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

    public function getAsetMohonAccept($id)
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
                'tbl_mohon.tgl_mulai_accept',
                'tbl_mohon.tgl_akhir_accept',
                'tbl_mohon.jam_mulai_accept',
                'tbl_mohon.jam_akhir_accept',
                'tbl_mohon.created_at',
                'tbl_mohon.status',

                'users.name'
            )

            ->join('users', 'tbl_mohon.id_user', '=', 'users.id', 'left')
            ->join('aset', 'aset.id', '=', 'tbl_mohon.id_aset', 'left')
            ->when(auth()->user()->role === 'opd' || auth()->user()->role === 'verifikator', function ($query) {
                return $query->where('aset.id_unit', session('id_unit'));
            })
            ->where('tbl_mohon.id_aset', $id)
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
                'tbl_mohon.jam_mulai',
                'tbl_mohon.jam_akhir',
                'tbl_mohon.created_at',
                'tbl_mohon.status',
                'tbl_mohon.tgl_mulai_accept',
                'tbl_mohon.tgl_akhir_accept',
                'tbl_mohon.jam_mulai_accept',
                'tbl_mohon.jam_akhir_accept',
                // Memisahkan date_agree menjadi tanggal dan waktu
                DB::raw('DATE(tbl_mohon.date_agree) as date_agree_date'),
                DB::raw('TIME(tbl_mohon.date_agree) as date_agree_time'),

                // Memisahkan date_verif menjadi tanggal dan waktu
                DB::raw('DATE(tbl_mohon.date_verif) as date_verif_date'),
                DB::raw('TIME(tbl_mohon.date_verif) as date_verif_time'),

                // Memisahkan date_finish menjadi tanggal dan waktu
                DB::raw('DATE(tbl_mohon.date_finish) as date_finish_date'),
                DB::raw('TIME(tbl_mohon.date_finish) as date_finish_time'),

                'users.name'
            )

            ->join('users', 'tbl_mohon.id_user', '=', 'users.id', 'left')
            ->join('aset', 'aset.id', '=', 'tbl_mohon.id_aset', 'left')
            ->when(auth()->user()->role === 'opd' || auth()->user()->role === 'verifikator', function ($query) {
                return $query->where('aset.id_unit', session('id_unit'));
            })
            ->where('tbl_mohon.id_aset', $id)
            ->where('tbl_mohon.status', 3)
            
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

    public function getAsetMohonReject($id)
    {
        $query = DB::table('tbl_mohon')
            ->select(

                'tbl_mohon.id as id_mohon',
                'tbl_mohon.id as id_aset',
                'tbl_mohon.catatan',
                'tbl_mohon.srt_mohon',
                'tbl_mohon.note_reject',
                'tbl_mohon.tgl_mulai',
                'tbl_mohon.tgl_akhir',
                'tbl_mohon.jam_mulai',
                'tbl_mohon.jam_akhir',
                'tbl_mohon.created_at',
                'tbl_mohon.status',

                // Memisahkan date_agree menjadi tanggal dan waktu
                DB::raw('DATE(tbl_mohon.date_reject) as date_reject_date'),
                DB::raw('TIME(tbl_mohon.date_reject) as date_reject_time'),



                'users.name'
            )

            ->join('users', 'tbl_mohon.id_user', '=', 'users.id', 'left')
            ->join('aset', 'aset.id', '=', 'tbl_mohon.id_aset', 'left')
            ->when(auth()->user()->role === 'opd' || auth()->user()->role === 'verifikator', function ($query) {
                return $query->where('aset.id_unit', session('id_unit'));
            })
            ->where('tbl_mohon.id_aset', $id)
            ->where('tbl_mohon.status', 4)
            
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
        $status = $request->input('status_mohon');
        $note_reject = $request->input('note_reject');

        $aset = DB::table('aset')->where('id', $id_aset_select)->first();

        if ($aset->status == 1) {
            return response()->json(['success' => false, 'message' => 'Aset dalam pemeliharaan']); // 404: Not Found
        }

        //verifikasi
        if ($status == 1) {
            $validate = [
                'jml_mohon' => DB::raw('jml_mohon - 1'),
            ];

            try {
                DB::table('aset')
                    ->where('id', $id_aset_select)
                    ->update($validate);

                DB::table('tbl_mohon')
                    ->where('id', $id_mohon_select)
                    ->update([

                        'status' => $status, //verifikasi
                        'tgl_mulai_accept' => $jadwal_mulai,
                        'tgl_akhir_accept' => $jadwal_akhir,
                        'jam_mulai_accept' => $jadwal_mulai_time,
                        'jam_akhir_accept' => $jadwal_akhir_time,
                        'reschedule_mohon' => $reschedule,
                        'date_verif' => Carbon::now()->format('Y-m-d H:i:s'),

                    ]);
                return response()->json(['success' => true, 'message' => 'Aset berhasil diperbarui']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui Aset. Error: ' . $e->getMessage()]);
            }
            //accept
        } else if ($status == 2) {
            try {

                DB::table('tbl_mohon')
                    ->where('id', $id_mohon_select)
                    ->update([

                        'status' => $status, //verifikasi
                        'tgl_mulai_accept' => $jadwal_mulai,
                        'tgl_akhir_accept' => $jadwal_akhir,
                        'jam_mulai_accept' => $jadwal_mulai_time,
                        'jam_akhir_accept' => $jadwal_akhir_time,
                        'reschedule_mohon' => $reschedule,
                        'date_agree' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
                return response()->json(['success' => true, 'message' => 'Aset berhasil diperbarui']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui Aset. Error: ' . $e->getMessage()]);
            }
        } else if ($status == 4) {
            try {

                DB::table('tbl_mohon')
                    ->where('id', $id_mohon_select)
                    ->update([

                        'note_reject' => $note_reject, //verifikasi
                        'status' => $status, //verifikasi
                        'date_reject' => Carbon::now()->format('Y-m-d H:i:s'),
                    ]);
                return response()->json(['success' => true, 'message' => 'Aset berhasil diperbarui']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui Aset. Error: ' . $e->getMessage()]);
            }
        }
    }

    public function finishAset($id_mohon)
    {


        try {

            DB::table('tbl_mohon')->where('id', $id_mohon)->update([
                'status' => 3,
                'date_finish' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            return response()->json(['success' => true, 'message' => 'Aset berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus Aset'], 500); // 500: Internal Server Error
        }
    }

    public function getAsetMohonVerifAll()
    {
        $data = [
            'title' => 'Verifikasi Permohonan'
        ];
        return view('admin/permohonan_verif', $data);
    }

    public function getAsetMohonVerifAllData()
    {
        $query = DB::table('tbl_mohon')
            ->select(

                'tbl_mohon.id as id_mohon',
                'tbl_mohon.id_aset as id_aset',
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
                  // Memisahkan date_verif menjadi tanggal dan waktu
                  DB::raw('DATE(tbl_mohon.date_verif) as date_verif_date'),
                  DB::raw('TIME(tbl_mohon.date_verif) as date_verif_time'),
                'users.name',
                'aset.id as id',
                'aset.nib_aset',
                'aset.nama_aset',
                'aset.id_kategori',
                'aset.deskripsi',
                'aset.status',
                'aset.img',
                'aset.created_at',
                'aset.updated_at',

            )

            ->join('users', 'tbl_mohon.id_user', '=', 'users.id', 'left')
            // ->join('aset', 'tbl_mohon.id_aset', '=', 'aset.id', 'left')
            ->join('aset', 'aset.id', '=', 'tbl_mohon.id_aset', 'left')
            ->when(auth()->user()->role === 'opd' || auth()->user()->role === 'verifikator', function ($query) {
                return $query->where('aset.id_unit', session('id_unit'));
            })

            ->where('tbl_mohon.status', 1)
           
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
                'tbl_mohon.id_aset as id_aset',
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
                // Memisahkan date_agree menjadi tanggal dan waktu
                DB::raw('DATE(tbl_mohon.date_agree) as date_agree_date'),
                DB::raw('TIME(tbl_mohon.date_agree) as date_agree_time'),

                // Memisahkan date_verif menjadi tanggal dan waktu
                DB::raw('DATE(tbl_mohon.date_verif) as date_verif_date'),
                DB::raw('TIME(tbl_mohon.date_verif) as date_verif_time'),

                // Memisahkan date_finish menjadi tanggal dan waktu
                DB::raw('DATE(tbl_mohon.date_finish) as date_finish_date'),
                DB::raw('TIME(tbl_mohon.date_finish) as date_finish_time'),
                'users.name',
                'aset.id as id',
                'aset.nib_aset',
                'aset.nama_aset',
                'aset.id_kategori',
                'aset.deskripsi',
                'aset.status',
                'aset.img',
                'aset.created_at',
                'aset.updated_at',

            )

            ->join('users', 'tbl_mohon.id_user', '=', 'users.id', 'left')
            ->join('aset', 'aset.id', '=', 'tbl_mohon.id_aset', 'left')
            ->when(auth()->user()->role === 'opd' || auth()->user()->role === 'verifikator', function ($query) {
                return $query->where('aset.id_unit', session('id_unit'));
            })

            ->where('tbl_mohon.status', 3)
            
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

    public function getDataStatus($id): JsonResponse
    {
        // Ambil data dari tabel tbl_mohon yang sesuai dengan id_aset dan hitung status
        $data = DB::table('tbl_mohon')
            ->select(DB::raw('status, COUNT(*) as count'))
            ->where('id_aset', $id)  // Kondisi where untuk id_aset
            ->groupBy('status')
            ->get();

        // Inisialisasi array dengan nilai default 0 untuk setiap status
        $result = [
            'sedang_dimohon' => 0,
            'dalam_verifikasi' => 0,
            'disetujui' => 0,
            'selesai' => 0,
            'ditolak' => 0
        ];

        // Loop melalui data dan isi jumlah berdasarkan status yang ditemukan
        foreach ($data as $item) {
            switch ($item->status) {
                case 0:
                    $result['sedang_dimohon'] = $item->count;
                    break;
                case 1:
                    $result['dalam_verifikasi'] = $item->count;
                    break;
                case 2:
                    $result['disetujui'] = $item->count;
                    break;
                case 3:
                    $result['selesai'] = $item->count;
                    break;
                case 4:
                    $result['ditolak'] = $item->count;
                    break;
            }
        }

        return response()->json($result, Response::HTTP_OK);
    }

    public function getAsetMohonRejectAll()
    {
        $data = [
            'title' => 'Permohonan ditolak'
        ];
        return view('admin/permohonan_reject', $data);
    }

    public function getAsetMohonRejectAllData()
    {
        $query = DB::table('tbl_mohon')
            ->select(

                'tbl_mohon.id as id_mohon',
                'tbl_mohon.id_aset as id_aset',
                'tbl_mohon.catatan',
                'tbl_mohon.srt_mohon',
                'tbl_mohon.tgl_mulai',
                'tbl_mohon.tgl_akhir',
                'tbl_mohon.jam_mulai',
                'tbl_mohon.jam_akhir',
                'tbl_mohon.created_at',
                'tbl_mohon.status',
                'tbl_mohon.note_reject',
                'tbl_mohon.tgl_mulai_accept',
                'tbl_mohon.tgl_akhir_accept',
                'tbl_mohon.jam_mulai_accept',
                'tbl_mohon.jam_akhir_accept',
                'tbl_mohon.reschedule_mohon',
                // Memisahkan date_agree menjadi tanggal dan waktu
                DB::raw('DATE(tbl_mohon.date_agree) as date_agree_date'),
                DB::raw('TIME(tbl_mohon.date_agree) as date_agree_time'),

                // Memisahkan date_verif menjadi tanggal dan waktu
                DB::raw('DATE(tbl_mohon.date_verif) as date_verif_date'),
                DB::raw('TIME(tbl_mohon.date_verif) as date_verif_time'),

                // Memisahkan date_finish menjadi tanggal dan waktu
                DB::raw('DATE(tbl_mohon.date_finish) as date_finish_date'),
                DB::raw('TIME(tbl_mohon.date_finish) as date_finish_time'),

                DB::raw('DATE(tbl_mohon.date_reject) as date_reject_date'),
                DB::raw('TIME(tbl_mohon.date_reject) as date_reject_time'),
                'users.name',
                'aset.id as id',
                'aset.nib_aset',
                'aset.nama_aset',
                'aset.id_kategori',
                'aset.deskripsi',
                'aset.status',
                'aset.img',
                'aset.created_at',
                'aset.updated_at',

            )

            ->join('users', 'tbl_mohon.id_user', '=', 'users.id', 'left')
            ->join('aset', 'aset.id', '=', 'tbl_mohon.id_aset', 'left')
            ->when(auth()->user()->role === 'opd' || auth()->user()->role === 'verifikator', function ($query) {
                return $query->where('aset.id_unit', session('id_unit'));
            })

            ->where('tbl_mohon.status', 4)
            
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
