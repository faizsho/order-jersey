<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diinput
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,super_admin,read'
        ]);

        // Simpan user baru ke database
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role' => $request->role,
        ]);

        return back()->with('success', 'Pengguna baru berhasil ditambahkan!');
    }
    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:user,super_admin,read']);
        $user->update(['role' => $request->role]);
        return back()->with('success', 'Role pengguna berhasil diubah!');
    }

    public function destroy(User $user)
    {
        // Cegah admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Anda tidak bisa menghapus akun Anda sendiri!']);
        }
        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus!');
    }

// === FUNGSI UBAH PASSWORD USER ===
    public function updatePassword(Request $request, User $user)
    {
        // Validasi input
        $request->validate([
            'password' => 'required|string|min:8'
        ]);

        // Update password yang sudah dienkripsi
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password pengguna ' . $user->name . ' berhasil di-reset!');
    }
}