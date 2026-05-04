<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    // Menampilkan halaman form input nama tim
    public function create()
    {
       if (Auth::user()->role === 'read') {
            abort(403, 'Akun Read-Only tidak diizinkan membuat tim.');
        }
        return view('teams.create');
    }

    // Menyimpan data tim ke database
// Menyimpan data tim ke database (Versi Update dengan Upload Desain)
    public function store(Request $request)
    {
        // KEAMANAN: Cek role
        if (Auth::user()->role === 'read') {
            abort(403, 'Akun Read-Only tidak diizinkan membuat tim.');
        }

        // 1. VALIDASI: Tambahkan aturan untuk file gambar
        $request->validate([
            'nama_team' => 'required|string|max:255',
            'desain_player' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'desain_kiper' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. LOGIKA UPLOAD: Siapkan variabel path
        $pathPlayer = null;
        $pathKiper = null;

        // Proses upload file Desain Player jika ada
        if ($request->hasFile('desain_player')) {
            $pathPlayer = $request->file('desain_player')->store('desain_teams', 'public');
        }

        // Proses upload file Desain Kiper jika ada
        if ($request->hasFile('desain_kiper')) {
            $pathKiper = $request->file('desain_kiper')->store('desain_teams', 'public');
        }

        // 3. SIMPAN KE DATABASE: Masukkan path gambar ke kolom masing-masing
        Team::create([
            'user_id'       => Auth::id(),
            'nama_team'     => $request->nama_team,
            'status_order'  => 'draft',
            'desain_player' => $pathPlayer,
            'desain_kiper'  => $pathKiper,
        ]);

        // Setelah sukses simpan, lempar kembali ke halaman dashboard
        return redirect()->route('dashboard')->with('success', 'Tim dan Desain berhasil didaftarkan!');
    }// Menampilkan detail tim khusus pelanggan
    public function show(Team $team)
    {
        // KEAMANAN 1: Pastikan yang buka adalah pemilik tim ini
        if ($team->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak! Ini bukan tim Anda.');
        }

        $team->load('jerseys');
        return view('teams.show', compact('team'));
    }
}