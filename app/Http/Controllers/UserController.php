<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * READ: Menampilkan daftar seluruh user (dengan pagination).
     */
    public function index()
    {
        $users = User::latest()->get(); // Mengambil semua data user terbaru
        return view('users.index', compact('users'));
    }

    /**
     * CREATE: Menampilkan form tambah user baru.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * CREATE: Menyimpan data user baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Data
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // 2. Simpan Data ke Database
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Redirect ke Halaman Index dengan Pesan Sukses
        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * READ: Menampilkan detail data user tertentu.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * UPDATE: Menampilkan form edit user.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * UPDATE: Memperbarui data user di database.
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi Input Data
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        // 2. Siapkan Data Perubahan
        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        // Update password hanya jika diisi oleh pengguna
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // 3. Eksekusi Update ke Database
        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * DELETE: Menghapus data user dari database.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus!');
    }

}
