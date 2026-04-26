<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(string $id): view
    {
         // data contoh( tanpa database)
         $user = [
        "id" => $id,
        "nama" => "Abi"
    ];

    return view('user.profile', compact('user'));
    }
}
