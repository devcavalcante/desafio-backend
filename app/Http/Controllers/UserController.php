<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = Auth::user();
        return response()->json(["user" => $user], 200);
    }

    public function showTypeUser()
    {
        $typeUser = Auth::user()->role->type;
        return response()->json(["type_user" => $typeUser], 200);
    }
}
