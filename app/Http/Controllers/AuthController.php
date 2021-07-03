<?php

namespace App\Http\Controllers;

use App\Repositories\AuthRepository;
use Illuminate\Auth\Access\AuthorizationException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->repository = $repository;
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors()], 422);
        }

        try {
            $fields = $request->only(['email', 'password']);
            $result = $this->repository->authenticate($fields);
            return response()->json($result);
        } catch (AuthorizationException $exception) {
            return response()->json(['errors' => $exception->getMessage()], 401);
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return response()->json(['errors' =>  $exception->getMessage()], 500);
        }
    }
}
