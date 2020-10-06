<?php

namespace App\Http\Repositories;
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
}
