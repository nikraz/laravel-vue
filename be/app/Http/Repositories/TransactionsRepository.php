<?php

namespace App\Http\Repositories;
use App\Transactions;
use Illuminate\Support\Collection;

class TransactionsRepository extends AbstractRepository
{
    /**
     * @param $orderBy
     * @param $orderByDir
     * @param $searchValue
     * @return Collection
     */
    public function getTransactionsByCriteria($orderBy, $orderByDir, $searchValue): Collection
    {

    if (! $orderBy) {
        $orderBy = 'id';
    }

    return \DB::table('transactions')
            ->join('user_transaction_accounts', 'user_transaction_accounts.id', '=', 'transactions.account_id')
            ->join('users', 'users.id', '=', 'user_transaction_accounts.user_id')
            ->join('transaction_types', 'transaction_types.id', '=', 'transactions.type_id')
            ->select(
                'transactions.id',
                \DB::raw("CONCAT(users.name,' {',user_transaction_accounts.balance,'}$')  AS user_balance"),
                'transaction_types.type',
                'transactions.amount'
            )
            ->where("users.name", "LIKE", "%$searchValue%")
            ->orWhere('users.email', "LIKE", "%$searchValue%")
            ->orWhere('transactions.amount', "LIKE", "%$searchValue%")
            ->orWhere('transaction_types.type', "LIKE", "%$searchValue%")
            ->orderBy($orderBy, $orderByDir)
            ->get();
    }

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
}
