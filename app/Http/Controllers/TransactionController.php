<?php


namespace App\Http\Controllers;

use App\Exceptions\CheckMoneyException;
use App\Exceptions\UserHasNoMoneyException;
use App\Http\Controllers\Controller;
use App\Repositories\TransactionRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\InvalidDataProviderException;
use Illuminate\Support\Facades\Validator;


class TransactionController extends Controller
{
    /**
     * @var TransactionRepository
     */
    private $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('checkrole:user');
        $this->middleware('auth:api');
    }

    public function transaction(Request $request)
    {
        DB::beginTransaction();
        $validator = Validator::make(request()->all(), [
            'payee_id' => 'required|uuid',
            'value' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response(['message' => 'Validation errors', 'errors' =>  $validator->errors()], 422);
        }

        $fields = $request->only(['payee_id', 'value']);
        try {
            $result = $this->repository->transaction($fields);
            DB::commit();
            return response()->json($result, 201);
        } catch (InvalidDataProviderException | UserHasNoMoneyException $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], $e->getCode());
        } catch (CheckMoneyException $th) {
            DB::rollBack();
            return response()->json(['errors' => $th->getMessage()], $th->getCode());
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['errors' => $e->getMessage()], $e->getCode());
        }
    }
}
