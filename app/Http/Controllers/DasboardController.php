<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DasboardController extends Controller
{
    //
    public function index()
    {
        $data = ['nama' => "Zahra", 'foto' => 'Avatar2.png'];
        $mahasiswa = Mahasiswa::with('prodi')->get();
        return view('dashboard', compact('data'));
    }
}
