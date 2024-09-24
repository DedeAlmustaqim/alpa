<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AsetModel;
use Illuminate\Http\Request;
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


    public function update(Request $request, $id)
    {
        $input_name = $request->input('input_name');

        $product = DB::table('nama_tabel')->find($id);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404); // 404: Not Found
        }

        try {
            DB::table('nama_tabel')
                ->where('id', $id)
                ->update([
                    'input_name' => $input_name,
                ]);

            return response()->json(['success' => true, 'message' => 'Produk berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui produk'], 500); // 500: Internal Server Error
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

            ->orderBy('aset.id', 'ASC');
        // Gunakan kondisi sesuai role login
        $query->when(auth()->user()->role === 'opd', function ($query) {
            return $query->where('aset.id_unit', session('id_unit'));
        });

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
                'aset.id_mohon',
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
                'aset.mulai_date',
                'aset.mulai_time',
                'aset.akhir_date',
                'aset.akhir_time',
                'aset.reschedule',
            )
            ->join('tbl_unit', 'aset.id_unit', '=', 'tbl_unit.id')
            ->join('kategori', 'aset.id_kategori', '=', 'kategori.id')
            ->where('status', 1)
            // ->where('table.id', $where)
            ->orderBy('aset.id', 'ASC');
        //Gunakan kondisi sesuai role login
        //->when(auth()->user()->role === 'role', function (query) {
        //return query->where('table.role', session('role'));
        //})


        // Gunakan kondisi sesuai role login
        $query->when(auth()->user()->role === 'opd', function ($query) {
            return $query->where('aset.id_unit', session('id_unit'));
        });

        $data = $query->get();

        return DataTables::of($data)

            ->make(true);
    }
}
