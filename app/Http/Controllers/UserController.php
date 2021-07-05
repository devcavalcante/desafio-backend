<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getUserLogged()
    {
        try {
            $user = Auth::user();
            return response()->json(["user" => $user], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showTypeUser()
    {
        try {
            $typeUser = Auth::user()->role->type;
            return response()->json(["type_user" => $typeUser], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
