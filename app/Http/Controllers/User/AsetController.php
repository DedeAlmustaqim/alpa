<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AsetController extends Controller
{
    public function asetDetail($id)
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

        $pinjam = DB::table('tbl_mohon')->where('id_aset', $id)->where('status', 2)->get();

        $data = [
            'title' => 'Aset Detail',
            'aset' => $aset,
            'pinjam' => $pinjam,
        ];
        return view('user.aset_detail', $data);
    }

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $validator = Validator::make($request->all(), [
            'id_aset' => 'required|string',
            'id_user' => 'required|string',
            'tgl_mulai' => 'required|string',
            // 'jam_mulai' => 'required|string',
            'tgl_akhir' => 'required|string',
            // 'jam_akhir' => 'required|string',
            'catatan' => 'required|string',
            'srt_mohon' => 'required|mimes:pdf|max:2048',
        ], [
            'id_aset.required' => 'ID Unit wajib diisi.',
            'id_user.required' => 'Kategori wajib diisi.',
            'tgl_mulai.required' => 'Nama aset wajib diisi.',
            'tgl_akhir.required' => 'NIB aset wajib diisi.',
            'catatan.required' => 'Deskripsi wajib diisi.',
            'srt_mohon.required' => 'Gambar aset wajib diunggah.',
            'srt_mohon.image' => 'File yang diunggah harus berupa PDF.',
            'srt_mohon.mimes' => 'File Surat Permohonan harus berupa file dengan format: pdf.',
            'srt_mohon.max' => 'Ukuran File Surat Permohonan tidak boleh lebih dari 2MB.',
        ]);

        // Jika validasi gagal, kembalikan respons JSON dengan pesan error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all() // Ambil semua error sebagai array
            ]); // 422: Unprocessable Entity
        }



        // Proses data dan simpan ke dalam database
        $id_aset = $request->input('id_aset');
        $id_user = $request->input('id_user');
        $tgl_mulai = $request->input('tgl_mulai');
        $jam_mulai = $request->input('jam_mulai');
        $tgl_akhir = $request->input('tgl_akhir');
        $jam_akhir = $request->input('jam_akhir');
        $catatan = $request->input('catatan');
        $image = $request->file('srt_mohon');
        $imagePath = 'storage/st_mohon/';
        $imageName = time() . '.' . $image->getClientOriginalExtension(); // Namai file dengan timestamp

        // Pindahkan file gambar ke direktori tujuan
        $image->move($imagePath, $imageName);
        // Periksa apakah kombinasi id_user dan id_aset sudah ada
        $exists = DB::table('tbl_mohon')
            ->where('id_aset', $id_aset)
            ->where('id_user', $id_user)
            ->where('status', 0)
            ->exists();

        // Periksa apakah ada permohonan lain dengan id_aset yang sudah ada dalam rentang tgl_mulai dan tgl_akhir
        $overlapExists = DB::table('tbl_mohon')
            ->where('status', 2)
            ->where(function ($query) use ($tgl_mulai, $tgl_akhir) {
                $query->whereBetween('tgl_mulai', [$tgl_mulai, $tgl_akhir])
                    ->orWhereBetween('tgl_akhir', [$tgl_mulai, $tgl_akhir])
                    ->orWhere(function ($query) use ($tgl_mulai, $tgl_akhir) {
                        $query->where('tgl_mulai', '<=', $tgl_mulai)
                            ->where('tgl_akhir', '>=', $tgl_akhir);
                    });
            })
            ->exists();

        if ($overlapExists) {
            // Jika ada data tumpang tindih, kembalikan respons dengan pesan
            return response()->json([
                'success' => false,
                'message' => 'Sudah ada permohonan dalam rentang tanggal tersebut.'
            ]); // 409 Conflict
        }


        if ($exists) {
            // Jika data sudah ada, kembalikan respons dengan pesan
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah mengajukan permohonan untuk aset ini.'
            ]); // 409 Conflict
        }

        try {
            // Masukkan data ke dalam tabel
            DB::table('tbl_mohon')->insert([
                'id_aset' => $id_aset,
                'id_user' => $id_user,
                'tgl_mulai' => $tgl_mulai,
                'jam_mulai' => $jam_mulai,
                'tgl_akhir' => $tgl_akhir,
                'jam_akhir' => $jam_akhir,
                'catatan' => $catatan,
                'srt_mohon' => url($imagePath . $imageName),
                'status' => 0

            ]);
            DB::table('aset')->where('aset.id', $id_aset)->update([
                'status' => 0,
                'jml_mohon' => DB::raw('jml_mohon + 1'),  // Increment jml_mohon by 1
                'updated_at' => Carbon::now()  // Update the updated_at with current timestamp
            ]);

            // Kembalikan respons sukses
            return response()->json([
                'success' => true,
                'message' => 'Berhasil simpan data'
            ], 201); // 201: Created
        } catch (\Exception $e) {
            // Kembalikan respons gagal
            return response()->json([
                'success' => false,
                'message' => 'Gagal simpan data' . $e
            ], 500); // 500: Internal Server Error
        }
    }

    public function list_aset()
    {

        $aset = DB::table('tbl_mohon')
            ->select(
                'aset.nama_aset',
                'aset.id as id_aset',
                'aset.nib_aset',
                'aset.deskripsi',
                'aset.img',
                'tbl_mohon.id as id_mohon',
                'tbl_mohon.catatan',
                'tbl_mohon.srt_mohon',
                'tbl_mohon.tgl_mulai',
                'tbl_mohon.tgl_akhir',
                'tbl_mohon.created_at',
                'tbl_mohon.status as status_permohonan',
                'tbl_mohon.reschedule_mohon',
                'tbl_mohon.jam_mulai',
                'tbl_mohon.jam_akhir',
                'tbl_mohon.tgl_mulai_accept',
                'tbl_mohon.tgl_akhir_accept',
                'tbl_mohon.jam_mulai_accept',
                'tbl_mohon.jam_akhir_accept',
                'kategori.kategori',
                'tbl_unit.nm_unit'
            )
            ->where('id_user', session('id'))
            ->join('aset', 'tbl_mohon.id_aset', '=', 'aset.id', 'left')
            ->join('kategori', 'aset.id_kategori', '=', 'kategori.id', 'left')
            ->join('tbl_unit', 'aset.id_unit', '=', 'tbl_unit.id', 'left')->get();
        $data = [
            'title' => 'Aset Saya',
            'aset' => $aset
        ];
        return view('user.my_aset', $data);
    }
}
