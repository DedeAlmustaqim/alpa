<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function app()
    {
        $config = DB::table('config')->first();
        $data = [
            'title' => 'Setting - Aplikasi',
            'config' => $config,
        ];
        return view('admin/app', $data);
    }


    public function updateConfig(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'app_name' => 'required|string|max:500',
            'pemda' => 'required|string|max:500',
            'alamat_config' => 'required|string',
            'email_config' => 'required|email',
            'tentang_config' => 'required|string',
        ]);

        $id = $request->input('id_config');

        // Cek apakah data ada
        $data = DB::table('config')->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        try {
            // Update data
            DB::table('config')
                ->where('id', $id)
                ->update([
                    'app_name' => $request->input('app_name'),
                    'pemda' => $request->input('pemda'),
                    'alamat' => $request->input('alamat_config'),
                    'email' => $request->input('email_config'),
                    'tentang' => $request->input('tentang_config'),
                ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
        } catch (\Exception $e) {
            // Redirect dengan pesan error jika gagal
            return redirect()->back()->with('error', 'Gagal memperbarui Pengaturan.');
        }
    }

    public function updateLogo(Request $request)
    {
        // Validasi file
        $request->validate([
            'logo' => 'required|file|mimes:jpg,jpeg,png|max:2048', // maksimal 2MB
        ]);

        // Ambil file yang diunggah
        $file = $request->file('logo');

        // Path file yang lama
        $filename = 'catalog/img/logo-app.' . $file->getClientOriginalExtension();
        $oldFilePath = public_path($filename); // Path absolut file lama

        // Cek apakah file lama ada dan hapus
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath); // Hapus file lama
        }

        // Simpan file baru di lokasi yang sama
        $file->move(public_path('catalog/img'), 'logo-app.' . $file->getClientOriginalExtension());

        // Update path logo di database
        DB::table('config')
            ->where('id', $request->input('id_config'))
            ->update(['logo' => '/' . $filename]);

        return redirect()->back()->with('success', 'Logo berhasil diperbarui.');
    }


    public function passReset()
    {
        $data = [
            'title' => 'Ubah Password'
        ];
        return view('admin/pass_reset', $data);
    }
    public function updateConfigPass(Request $request)
    {
        // Validasi manual dengan menangkap exception jika validasi gagal
        try {
            $validatedData = $request->validate([
                'password' => [
                    'required',
                    'string',
                    'min:6',
                    'max:500',
                    'regex:/^(?=.*[A-Z])(?=.*\d).+$/', // Password harus mengandung huruf besar dan angka
                ],
                'repeat_password' => 'required|string|same:password', // memastikan password cocok
            ],  [
                // Pesan custom untuk password
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal harus terdiri dari :min karakter.',
                'password.regex' => 'Password harus mengandung setidaknya satu huruf besar dan satu angka.',
                'repeat_password.required' => 'Konfirmasi password wajib diisi.',
                'repeat_password.same' => 'Konfirmasi password tidak sesuai dengan password.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Simpan error validasi ke dalam session dan redirect kembali dengan input
            return redirect()->back()->withErrors($e->validator)->withInput();
        }

        // Mengambil ID dari request
        $id = $request->input('id_user_pass');

        // Cek apakah data pengguna ada di dalam tabel users
        $data = DB::table('users')->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }else {
            
        }

        try {
            // Update data dengan password yang sudah di-hash
            DB::table('users')
                ->where('id', $id)
                ->update([
                    'password' => Hash::make($request->input('password')), // enkripsi password
                ]);

            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Password berhasil diperbarui.');
        } catch (\Exception $e) {
            // Redirect dengan pesan error jika gagal
            return redirect()->back()->with('error', 'Gagal memperbarui Password.');
        }
    }
}
