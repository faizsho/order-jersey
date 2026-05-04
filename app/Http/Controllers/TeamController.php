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
    public function store(Request $request)
    {
        if (Auth::user()->role === 'read') {
            abort(403, 'Akun Read-Only tidak diizinkan membuat tim.');
        }
        $request->validate([
            'nama_team' => 'required|string|max:255',
        ]);

        Team::create([
            'user_id' => Auth::id(), // Deteksi otomatis siapa yang lagi login
            'nama_team' => $request->nama_team,
            'status_order' => 'draft',
        ]);

        // Setelah sukses simpan, lempar kembali ke halaman dashboard
        return redirect()->route('dashboard')->with('success', 'Tim berhasil didaftarkan!');
    }
// Menampilkan detail tim khusus pelanggan
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