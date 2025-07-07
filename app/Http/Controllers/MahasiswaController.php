<?php

namespace App\Http\Controllers;

use App\Models\prodi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //                                                                                  
        $data = ['nama' => "Zahra", 'foto' => 'Avatar2.png'];
        $mahasiswa = Mahasiswa::with('prodi')->get();
        return view('mahasiswa.index', compact('data', 'mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data = ['nama' => "Zahra", 'foto' => 'Avatar2.png'];
        $prodi = Prodi::all();
        return view('mahasiswa.create', compact('data', 'prodi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate(
            [
                'nim' => 'required|unique:mahasiswa|max:10',
                'password' => 'required',
                'nama' => 'required|max:100',
                'tanggalLahir' => 'required',
                'telp' => 'required|max:20',
                'email' => 'required|max:100',
                'foto' => 'image|file|max:2048'
            ],
            [
                'nim.required' => 'NIM harus diisi',
                'nim.unique' => 'NIM sudah terdaftar',
                'nim.max' => 'NIM maksimal 10 karakter',
                'password.required' => 'Password wajib diisi',
                'nama.required' => 'Nama wajib diisi',
                'tanggalLahir.required' => 'Tanggal Lahir harus diisi',
                'telp.required' => 'Nomor telepon harus diisi',
                'email.required' => 'Email harus diisi',
                'foto' => 'File harus berupa gambar',
            ]
        );
        if ($request->file('foto')) {
            $validateData['foto'] = $request->file('foto')->store('image');
        }
        $validateData['password'] = Hash::make($validateData['password']);
        $data = array_merge($validateData, $request->only(['id']));
        Mahasiswa::create($data);
        return redirect('/mahasiswa');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = ['nama' => "Zahra", 'foto' => 'Avatar2.png'];
        $mahasiswa = Mahasiswa::find($id);
        $prodi = Prodi::all();
        return view('mahasiswa.edit', compact('data', 'mahasiswa', 'prodi'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate(
            [
                'nama' => 'required|max:100',
                'tanggalLahir' => 'required',
                'telp' => 'required|max:20',
                'email' => 'required|max:100',
            ],
            [
                'nama.required' => 'Nama wajib diisi',
                'tanggalLahir.required' => 'Tanggal Lahir harus diisi',
                'telp.required' => 'Nomor telepon harus diisi',
                'email.required' => 'Email harus diisi',
            ]
        );
        $mahasiswa = Mahasiswa::Find($id);
        if ($request->file('foto')) {
            if ($mahasiswa->foto) {
                Storage::delete($mahasiswa->foto);
            }
            $validateData['foto'] = $request->file('foto')->store('image');
        }
        if ($request->input('password')) {
            $validateData['password'] = Hash::make($request->password);
        }
        $data = array_merge($validateData, $request->only(['id']));
        Mahasiswa::where('nim', $id)->update($data);
        return redirect('/mahasiswa');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $mahasiswa = Mahasiswa::find($id);
        if ($mahasiswa->foto) {
            Storage::delete($mahasiswa->foto);
        }
        Mahasiswa::destroy($id);
        return redirect('/mahasiswa');
    }
}
