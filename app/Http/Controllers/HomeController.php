<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function profil()
    {
        $data = [
            'nama' => 'Atta Akramulhakim',
            'nim' => '241230036',
            'prodi' => 'Sistem Informasi',
            'kampus' => 'Universitas Muhammadiyah Pontianak'
        ];

        return view('profil', $data);
    }

    public function kontak()
    {
        $kontak = [
            'email' => 'atta.akramulhakim@email.com',
            'no_hp' => '081251737339',
            'alamat' => 'Pontianak, Kalimantan Barat'
        ];

        return view('kontak', $kontak);
    }
}
