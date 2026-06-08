<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 25);
        $pegawai = Pegawai::with('user')->paginate($perPage);
        return view('pegawai.index', compact('pegawai', 'perPage'));
    }

    public function create()
    {
        return view('pegawai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@gmail.com')) {
                        $fail('Email harus menggunakan domain @gmail.com');
                    }
                },
            ],
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:owner,peternak',
        ]);

        // 1. Buat User baru untuk pegawai
        $user = \App\Models\User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => \Hash::make($request->password),
            'role' => $request->role,
        ]);

        // 2. Buat record Pegawai baru yang terhubung ke User
        Pegawai::create([
            'id_user' => $user->id,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai dan Akun Login berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::with('user')->findOrFail($id);
        return view('pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . $pegawai->id_user,
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@gmail.com')) {
                        $fail('Email harus menggunakan domain @gmail.com');
                    }
                },
            ],
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|in:owner,peternak',
        ]);

        // 1. Update data Pegawai
        $pegawai->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
        ]);

        // 2. Update data User terkait
        if ($pegawai->id_user) {
            $user = \App\Models\User::findOrFail($pegawai->id_user);
            $userData = [
                'name' => $request->nama,
                'email' => $request->email,
                'role' => $request->role,
            ];
            
            if ($request->filled('password')) {
                $userData['password'] = \Hash::make($request->password);
            }
            
            $user->update($userData);
        }

        return redirect()->route('pegawai.index')->with('success', 'Pegawai dan Akun Login berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $id_user = $pegawai->id_user;

        // Hapus data pegawai terlebih dahulu (karena foreign key berada di tabel pegawai)
        $pegawai->delete();

        // Hapus akun login user terkait
        if ($id_user) {
            \App\Models\User::destroy($id_user);
        }

        return redirect()->route('pegawai.index')->with('success', 'Pegawai dan Akun Login terkait berhasil dihapus');
    }
}
