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
                'users.name',
                'user_transaction_accounts.balance',
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
     * @return void
     */
    public function removeTransactionById(int $id): void
    {
            $transaction = Transactions::findOrFail($id);
            $transaction->delete();
    }

    //Normally should return collection of new record and resource todo if time
    /**
     * @param $amount
     * @param $type_id
     * @param $utc_id
     */
    public function storeTransaction($amount, $type_id, $utc_id): void
    {
           Transactions::create([
                'account_id' => $utc_id,
                'amount' => $amount,
                'type_id' => $type_id,
            ]);
    }

    /**
     * @param $id
     * @param $amount
     * @return void
     */
    public function updateAmountById($id, $amount): void
    {
        $transaction = Transactions::find($id);

        $transaction->amount = $amount;
        $transaction->save();
    }

    /**
     * @param $id
     * @param $typeId
     * @return void
     */
    public function updateTypeById($id, $typeId): void
    {
        $transaction = Transactions::find($id);

        $transaction->type_id = $typeId;
        $transaction->save();
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
