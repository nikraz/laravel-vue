<?php

namespace App\Http\Repositories;
use Illuminate\Support\Collection;

class UserTransactionAccountsRepository extends AbstractRepository
{
    /**
     * @param $name
     * @return int
     */
    public function getUserTransactionAccountIdByUserName($name): int
    {
        return \DB::table('user_transaction_accounts')
            ->join('users', 'user_transaction_accounts.user_id', '=', 'users.id')
            ->select(
                'user_transaction_accounts.id'
            )
            ->where("users.name", "=", "$name")
            ->first()->id;
    }

}