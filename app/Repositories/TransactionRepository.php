<?php


namespace App\Repositories;

use App\Events\SendNotification;
use App\Exceptions\CheckMoneyException;
use App\Exceptions\FailTransactionException;
use App\Exceptions\UserHasNoMoneyException;
use App\Models\Transaction;
use App\Models\Wallet;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

class TransactionRepository
{

    public function transaction(array $fields): array
    {

        if (!$this->userHasMoney($fields['value'])) {
            throw new UserHasNoMoneyException('Insuficient Balance', 422);
        }

        if (!$this->checkMoney($fields['value'])) {
            throw new CheckMoneyException('cannot transfer 0', 403);
        }

        if (!$this->authorizeUserMakeTransaction()) {
            throw new FailTransactionException('Unauthorized. Try again later', 401);
        }

        if (Auth::id() == $fields['payee_id']) {
            throw new FailTransactionException('forbidden to transfer to yourself', 403);
        }
        return $this->makeTransfer($fields);
    }

    private function userHasMoney($money): bool
    {
        $wallet = Wallet::where('user_id', '=', Auth::id())->firstOrFail();
        return $wallet->balance >= $money;
    }

    private function checkMoney($money): bool
    {
        return $money != 0.00;
    }

    private function makeTransfer(array $fields): array
    {
        $transfer = [
            'id' => Uuid::uuid4()->toString(),
            'payer_id' => Auth::id(),
            'payee_id' => $fields['payee_id'],
            'value' => $fields['value']
        ];

        $transaction = Transaction::create($transfer);
        $walletPayer = $transaction->payer->wallet;
        $walletPayer->balance = $walletPayer->balance - $fields['value'];
        $walletPayer->save();

        $walletPayee = $transaction->payee->wallet;
        $walletPayee->balance = $walletPayee->balance + $fields['value'];
        $walletPayee->save();

        $send = event(new SendNotification($transaction));

        return [$transaction, $send];
    }

    private function authorizeUserMakeTransaction(): array
    {
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->request('GET', 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $exception) {
            return ['message' => 'Forbidden'];
        }
    }
}
