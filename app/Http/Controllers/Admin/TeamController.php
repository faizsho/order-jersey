<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

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

}