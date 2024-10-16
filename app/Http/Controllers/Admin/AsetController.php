<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use function Laravel\Prompts\select;

class AsetController extends Controller
{
    public function index()
    {
        // Menghitung jumlah aset berdasarkan status (1 dan 2) dalam satu query


        $unit = DB::table('tbl_unit')->get();

        $kategori = DB::table('kategori')->get();
        $data = [
            'title' => 'Aset',
            'unit' => $unit,
            'kategori' => $kategori,

        ];
        return view('admin.aset', $data);
    }
    public function asetPinjam()
    {
        $data = [
            'title' => 'Aset dipinjam'
        ];
        return view('admin.aset_pinjam', $data);
    }

    public function getAset()
    {
        $page = 10;
        $data = DB::table('aset')->paginate($page);
        return response()->json($data);
    }

    public function getDataAsetbyId($id): JsonResponse
    {
        $data = DB::table('aset')
            ->where('aset.id', $id)

            ->first();

        if ($data) {
            return response()->json($data, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $validator = Validator::make($request->all(), [
            'id_unit' => 'required|string',
            'kategori' => 'required|string',
            'nama_aset' => 'required|string',
            'nib_aset' => 'required|string',
            'deskripsi' => 'required|string',
            'img_aset' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'id_unit.required' => 'ID Unit wajib diisi.',
            'kategori.required' => 'Kategori wajib diisi.',
            'nama_aset.required' => 'Nama aset wajib diisi.',
            'nib_aset.required' => 'NIB aset wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'img_aset.required' => 'Gambar aset wajib diunggah.',
            'img_aset.image' => 'File yang diunggah harus berupa gambar.',
            'img_aset.mimes' => 'Gambar aset harus berupa file dengan format: jpeg, png, jpg, atau gif.',
            'img_aset.max' => 'Ukuran gambar aset tidak boleh lebih dari 2MB.',
        ]);

        // Jika validasi gagal, kembalikan respons JSON dengan pesan error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all() // Ambil semua error sebagai array
            ]); // 422: Unprocessable Entity
        }

        // Proses data dan simpan ke dalam database
        $id_unit = $request->input('id_unit');
        $kategori = $request->input('kategori');
        $nama_aset = $request->input('nama_aset');
        $status = $request->input('status');
        $nib_aset = $request->input('nib_aset');
        $deskripsi = $request->input('deskripsi');
        $image = $request->file('img_aset');
        $imagePath = 'storage/aset/';
        $imageName = time() . '.' . $image->getClientOriginalExtension(); // Namai file dengan timestamp

        // Pindahkan file gambar ke direktori tujuan
        $image->move($imagePath, $imageName);

        try {
            // Masukkan data ke dalam tabel
            DB::table('aset')->insert([
                'id_unit' => $id_unit,
                'id_kategori' => $kategori,
                'nama_aset' => $nama_aset,
                'nib_aset' => $nib_aset,
                'status' => $status,
                'deskripsi' => $deskripsi,
                'img' => url($imagePath . $imageName),

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
                'message' => 'Gagal simpan data'
            ], 500); // 500: Internal Server Error
        }
    }


    public function update(Request $request)
    {
        $id = $request->input('id_aset_edit');
        $cekData = DB::table('aset')->where('id', $id)->first();
        // Validasi data yang masuk
        $validator = Validator::make($request->all(), [
            'id_unit_edit' => 'required|string',
            'kategori_edit' => 'required|string',
            'nama_aset_edit' => 'required|string',
            'nib_aset_edit' => 'required|string',
            'deskripsi_edit' => 'required|string',
            'img_aset_edit' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Nullable, artinya opsional
            'status_edit' => [
                'required',
                'in:0,1,2', // Status yang valid: 0 (Tersedia), 1 (Dipinjam), 2 (Pemeliharaan)
                function ($attribute, $value, $fail) use ($cekData) {
                    // Validasi jika status saat ini adalah Dipinjam (1), tidak boleh diubah menjadi Tersedia (0)
                    // if ($cekData->status == 1 && $value == 0) {
                    //     $fail('Status tidak boleh diubah ke Tersedia  jika aset saat ini Dipinjam .');
                    // }

                    // Validasi jika jumlah permohonan tidak 0 atau status saat ini 1, tidak boleh diubah menjadi Pemeliharaan (2)
                    if ($cekData->jml_mohon != 0) {
                        $fail('Status tidak boleh diubah ke Pemeliharaan jika ada permohonan');
                    }
                },
            ],
        ], [
            'id_unit_edit.required' => 'ID Unit wajib diisi.',
            'kategori_edit.required' => 'Kategori wajib diisi.',
            'nama_aset_edit.required' => 'Nama aset wajib diisi.',
            'nib_aset_edit.required' => 'NIB aset wajib diisi.',
            'deskripsi_edit.required' => 'Deskripsi wajib diisi.',
            'img_aset_edit.image' => 'File yang diunggah harus berupa gambar.',
            'img_aset_edit.mimes' => 'Gambar aset harus berupa file dengan format: jpeg, png, jpg, atau gif.',
            'img_aset_edit.max' => 'Ukuran gambar aset tidak boleh lebih dari 2MB.',
        ]);

        // Jika validasi gagal, kembalikan respons JSON dengan pesan error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all() // Ambil semua error sebagai array
            ]); // 422: Unprocessable Entity
        }

        // Proses data dan simpan ke dalam database

        $id_unit = $request->input('id_unit_edit');
        $kategori = $request->input('kategori_edit');
        $nama_aset = $request->input('nama_aset_edit');
        $status = $request->input('status_edit');
        $nib_aset = $request->input('nib_aset_edit');
        $deskripsi = $request->input('deskripsi_edit');




        // Cek apakah ada gambar baru yang diunggah
        if ($request->hasFile('img_aset_edit')) {
            // Nama file baru
            $image = $request->file('img_aset_edit');
            $imagePath = 'storage/aset/';
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Namai file dengan timestamp

            // Hapus gambar lama jika ada
            if ($cekData && $cekData->img) {
                $oldImage = str_replace(url(''), '', $cekData->img); // Hilangkan base URL
                if (file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage)); // Hapus file gambar lama
                }
            }

            // Pindahkan file gambar ke direktori tujuan
            $image->move($imagePath, $imageName);
            $img = url($imagePath . $imageName); // URL untuk gambar baru
        } else {
            // Jika tidak ada gambar baru, gunakan gambar yang lama
            $img = $cekData->img;
        }

        try {
            // Update data di tabel
            DB::table('aset')->where('id', $id)->update([
                'id_unit' => $id_unit,
                'id_kategori' => $kategori,
                'nama_aset' => $nama_aset,
                'nib_aset' => $nib_aset,
                'status' => $status,
                'deskripsi' => $deskripsi,
                'img' => $img, // Gambar baru atau lama
            ]);

            // Kembalikan respons sukses
            return response()->json([
                'success' => true,
                'message' => 'Berhasil memperbarui data'
            ], 200); // 200: OK
        } catch (\Exception $e) {
            // Kembalikan respons gagal
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data'
            ], 500); // 500: Internal Server Error
        }
    }




    public function destroy($id)
    {
        $product = DB::table('aset')->find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404); // 404: Not Found
        }

        try {
            if (isset($product->img) && file_exists(public_path($product->img))) {
                unlink(public_path($product->img));
            }

            DB::table('aset')->where('id', $id)->delete();

            return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus produk'], 500); // 500: Internal Server Error
        }
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
                'tbl_unit.nm_unit',
                'tbl_unit.pimpinan',
                'tbl_unit.nip_pimpinan',
                'tbl_unit.gol',
                'tbl_unit.jabatan',
                'kategori.kategori',

            )
            ->join('tbl_unit', 'aset.id_unit', '=', 'tbl_unit.id')
            ->join('kategori', 'aset.id_kategori', '=', 'kategori.id')
            ->when($status, function ($query, $status) {
                return $query->where('aset.status', $status);
            })
            ->when(auth()->user()->role === 'opd' || auth()->user()->role === 'verifikator', function ($query) {
                return $query->where('aset.id_unit', session('id_unit'));
            })
            ->orderBy('aset.id', 'ASC');
      

        $data = $query->get();

        return DataTables::of($data)

            ->make(true);
    }
    public function getAsetDatatablePinjam(Request $request)
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
                'tbl_unit.nm_unit',
                'tbl_unit.pimpinan',
                'tbl_unit.nip_pimpinan',
                'tbl_unit.gol',
                'tbl_unit.jabatan',
                'kategori.kategori',
                DB::raw('COUNT(tbl_mohon.id) as dipinjam')  // Tambahkan field jumlah_status_2
            )
            ->join('tbl_unit', 'aset.id_unit', '=', 'tbl_unit.id')
            ->join('kategori', 'aset.id_kategori', '=', 'kategori.id')
            ->join('tbl_mohon', function ($join) {
                $join->on('aset.id', '=', 'tbl_mohon.id_aset')
                    ->where('tbl_mohon.status', '=', 2);  // Kondisi where untuk status 2
            })
            ->when(auth()->user()->role === 'opd' || auth()->user()->role === 'verifikator', function ($query) {
                return $query->where('aset.id_unit', session('id_unit'));
            })
            ->groupBy('aset.id')  // Kelompokkan berdasarkan aset.id agar data tidak duplikat
            ->orderBy('aset.id', 'ASC');


        $data = $query->get();

        return DataTables::of($data)
            ->make(true);
    }
}
