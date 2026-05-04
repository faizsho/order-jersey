<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Jersey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // JIKA YANG LOGIN ADALAH SUPER ADMIN
        if ($user->role === 'super_admin') {
            $totalTim = Team::count();
            $totalBaju = Jersey::count();
            $timTerbaru = Team::with('user')->latest()->take(5)->get();
            
            return view('admin.dashboard', compact('totalTim', 'totalBaju', 'timTerbaru'));
        }

        // JIKA YANG LOGIN ADALAH CUSTOMER BIASA
        $myTeams = Team::where('user_id', $user->id)->latest()->get();
        return view('customer.dashboard', compact('myTeams'));
    }
}