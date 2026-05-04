<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        // Ambil semua data tim beserta data user dan jerseynya
        $teams = Team::with(['user', 'jerseys'])->latest()->get();
        
        return view('admin.teams.index', compact('teams'));
    }

    public function show(Team $team)
    {
        $team->load('jerseys');
        return view('admin.teams.show', compact('team'));
    }
public function destroy(Team $team)
    {
        // Hapus semua data baju yang nyantol di tim ini dulu biar database nggak error
        $team->jerseys()->delete();
        
        // Setelah bajunya bersih, baru hapus nama timnya
        $team->delete();

        return back()->with('success', 'Tim beserta seluruh data bajunya berhasil dihapus!');
    }

public function updateStatus(Request $request, Team $team)
    {
        // Validasi status yang diizinkan
        $request->validate([
            'status' => 'required|in:draft,produksi,selesai'
        ]);

        // Update status di database
        $team->update([
            'status_order' => $request->status
        ]);

        return back()->with('success', 'Status tim ' . $team->nama_team . ' berhasil diubah menjadi ' . strtoupper($request->status));
    }

// === FUNGSI REVISI DESAIN (KHUSUS ADMIN) ===
    public function updateDesain(Request $request, Team $team)
    {
        $request->validate([
            'desain_player' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'desain_kiper' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 1. Jika Admin upload revisi desain Player
        if ($request->hasFile('desain_player')) {
            // Hapus gambar lama dari server (jika ada)
            if ($team->desain_player) {
                Storage::disk('public')->delete($team->desain_player);
            }
            // Simpan gambar baru
            $team->desain_player = $request->file('desain_player')->store('desain_teams', 'public');
        }

        // 2. Jika Admin upload revisi desain Kiper
        if ($request->hasFile('desain_kiper')) {
            // Hapus gambar lama dari server (jika ada)
            if ($team->desain_kiper) {
                Storage::disk('public')->delete($team->desain_kiper);
            }
            // Simpan gambar baru
            $team->desain_kiper = $request->file('desain_kiper')->store('desain_teams', 'public');
        }

        $team->save();

        return back()->with('success', 'Gambar desain berhasil direvisi!');
    }

}