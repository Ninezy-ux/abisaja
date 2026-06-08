<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function show($id)
    {
        // data contoh (tanpa database)
        $user = [
            "id" => $id,
            "nama" => "Hasby"
        ];

        return view('user.profile', compact('user'));
    }
}