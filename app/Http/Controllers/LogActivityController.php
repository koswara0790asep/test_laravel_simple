<?php

namespace App\Http\Controllers;

use App\Models\LogActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogActivityController extends Controller
{
        /**
     * Menampilkan daftar riwayat aktivitas log.
     */
    public function index()
    {
        // Ambil data log beserta informasi user terhubung
        if (Auth::user()->role === 'staff') {
            $logs = LogActivity::with('user')->latest()->get();
        } else {
            $logs = LogActivity::where('user_id', Auth::user()->id)->get();
        }

        return view('log_activities.index', compact('logs'));
    }

    /**
     * Menghapus seluruh catatan log (Clear Log)
     */
    public function destroyAll()
    {
        LogActivity::truncate();

        return redirect()->back()->with('success', 'Seluruh riwayat log aktivitas berhasil dibersihkan!');
    }

}
