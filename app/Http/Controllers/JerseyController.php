<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JerseyExport;
use App\Imports\JerseyImport;

class JerseyController extends Controller
{
    // === FUNGSI TAMBAH BAJU ===
    public function store(Request $request, Team $team)
    {
        if (Auth::user()->role === 'read') {
            abort(403, 'Akun Read-Only tidak diizinkan mengubah/menghapus data baju.');
        }
        // KEAMANAN 2: Jika yang login BUKAN Admin
        if (Auth::user()->role !== 'super_admin') {
            // Tolak jika bukan tim miliknya
            if ($team->user_id !== Auth::id()) {
                abort(403, 'Bukan tim Anda!');
            }
            // Tolak jika status sudah bukan DRAFT
            if ($team->status_order !== 'draft') {
                return back()->withErrors(['error' => 'Pesanan sudah dikunci/diproses. Anda tidak bisa menambah baju lagi.']);
            }
        }

        // Validasi inputan
        $request->validate([
            'nama_punggung' => 'required|string|max:255',
            'nomor_punggung' => 'required|string|max:10',
            'ukuran' => 'required|string',
            'lengan' => 'required|string',
            'kategori' => 'required|string',
        ]);

        // Simpan data baju ke tim yang bersangkutan
        $team->jerseys()->create($request->all());

        return back()->with('success', 'Baju berhasil ditambahkan!');
    }

    // === FUNGSI HAPUS BAJU ===
    public function destroy(Team $team, $jerseyId)
    {
        if (Auth::user()->role === 'read') {
            abort(403, 'Akun Read-Only tidak diizinkan mengubah/menghapus data baju.');
        }
        // KEAMANAN: Kalau bukan Admin, cek apakah ini tim miliknya dan statusnya DRAFT
        if (Auth::user()->role !== 'super_admin') {
            if ($team->user_id !== Auth::id() || $team->status_order !== 'draft') {
                abort(403, 'Anda tidak memiliki akses untuk menghapus baju ini!');
            }
        }

        // Cari bajunya dan hapus
        $jersey = $team->jerseys()->findOrFail($jerseyId);
        $jersey->delete();

        return back()->with('success', 'Data baju berhasil dihapus!');
    }
// === FUNGSI EXPORT (Semua Role Bisa) ===
    public function export(Team $team)
    {
        // Cek Keamanan
        if (Auth::user()->role !== 'super_admin' && $team->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak!');
        }

        return Excel::download(new JerseyExport($team->id), 'Daftar_Baju_' . $team->nama_team . '.xlsx');
    }

    // === FUNGSI IMPORT (Read-Only Dilarang) ===
    public function import(Request $request, Team $team)
    {
        // Cek apakah akun Read-Only
        if (Auth::user()->role === 'read') {
            abort(403, 'Akun Read-Only tidak diizinkan melakukan Import!');
        }

        // Cek Keamanan untuk User Biasa
        if (Auth::user()->role !== 'super_admin') {
            if ($team->user_id !== Auth::id()) abort(403, 'Bukan tim Anda!');
            if ($team->status_order !== 'draft') return back()->withErrors(['error' => 'Pesanan sudah dikunci.']);
        }

        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new JerseyImport($team->id), $request->file('file_excel'));

        return back()->with('success', 'Data baju berhasil di-import dari Excel!');
    }
}