<?php

namespace App\Http\Repositories;

use App\UserTransactionAccounts;

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

    /**
     * @param $id
     * @param $balance
     * @return bool
     */
    public function updateBalanceById($id, $balance): bool
    {
        $uta = UserTransactionAccounts::find($id);

        if ($uta) {
            $uta->balance = $balance;
            $uta->save();
            return true;
        }

        return false;
    }


    /**
     * @param $id
     * @return int
     */
    public function getUserById($id): int
    {
        $uta = UserTransactionAccounts::find($id);

        if ($uta) {
            return $uta->user_id;
        }

        return 0;
    }
}
