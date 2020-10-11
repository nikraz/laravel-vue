<?php

namespace App\Http\Repositories;
use App\Transactions;
use Illuminate\Support\Collection;

class TransactionsRepository extends AbstractRepository
{

    //Query builder used
    /**
     * @param $orderBy
     * @param $orderByDir
     * @return Collection
     */
    public function getTransactionsByCriteria($orderBy, $orderByDir): Collection
    {
    return \DB::table('transactions')
            ->join('user_transaction_accounts', 'user_transaction_accounts.id', '=', 'transactions.account_id')
            ->join('users', 'users.id', '=', 'user_transaction_accounts.user_id')
            ->join('transaction_types', 'transaction_types.id', '=', 'transactions.type_id')
            ->select(
                'transactions.id',
                \DB::raw("CONCAT(users.name,' (',user_transaction_accounts.balance,')$')  AS user_balance"),
                'transaction_types.type',
                'transactions.amount',
                'users.email'
            )
            ->orderBy($orderBy, $orderByDir)
            ->get();
    }

    //Used models
    /**
     * @param int $id
     * @return bool
     */
    public function removeTransactionById(int $id): bool
    {
            $transaction = Transactions::findOrFail($id);

            if($transaction){
                $transaction->delete();
                return true;
            }

            return false;
    }

    //Normally should return collection of new record and resource todo if time
    public function storeTransaction($amount, $type_id, $utc_id): bool
    {
        try {
           $trans = Transactions::create([
                'account_id' => $utc_id,
                'amount' => $amount,
                'type_id' => $type_id,
            ]);
            $trans->save();
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * @param $id
     * @param $amount
     * @return bool
     */
    public function updateAmountById($id, $amount): bool
    {
        $transaction = Transactions::find($id);

        if ($transaction) {
            $transaction->amount = $amount;
            $transaction->save();
            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @param $typeId
     * @return bool
     */
    public function updateTypeById($id, $typeId): bool
    {
        $transaction = Transactions::find($id);

        if ($transaction) {
            $transaction->type_id = $typeId;
            $transaction->save();
            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @return int
     */
    public function getAccountIdById($id): int
    {
        $transaction = Transactions::find($id);

        if ($transaction) {
            return $transaction->account_id;
        }

        return 0;
    }
}
