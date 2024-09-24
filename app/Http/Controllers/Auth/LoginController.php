<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        $data = [
            'title' => 'Login'
        ];
        return view('auth.login', $data);
    }

    public function login(Request $request)
    {
        // Validasi input dari form login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        

        
        // Coba autentikasi pengguna
        if (Auth::attempt($credentials)) {
            // Regenerasi sesi untuk mencegah serangan session fixation
            $request->session()->regenerate();
            // Ambil pengguna yang sedang login
            $user = Auth::user();
            if ($user->active == 0) {
                return redirect()->back()->with('error', 'Akun belum Aktif.');
            }
            // Simpan data pengguna ke session
            $request->session()->put([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'no_hp' => $user->no_hp,
                'nip' => $user->nip,
                'id_unit' => $user->id_unit,

            ]);
            // Arahkan pengguna sesuai dengan role
            return $this->redirectBasedOnRole();
        }

        // Jika login gagal, kembalikan ke halaman login dengan pesan error
        return redirect()->back()->with('error', 'Email atau Password salah');
    }

    protected function redirectBasedOnRole()
    {

        if (auth()->user()->role === 'admin') {
            return redirect('admin/dashboard');
        } elseif (auth()->user()->role === 'opd') {
            return redirect('admin/dashboard');
        } elseif (auth()->user()->role === 'pengguna') {
            return redirect('user/dashboard'); // Gunakan nama rute yang sesuai
        }



        // Default redirect jika role tidak terdeteksi
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
