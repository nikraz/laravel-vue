<?php

use Illuminate\Database\Seeder;
use App\UserTransactionAccounts;

class UserTransactionAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_transaction_accounts')->truncate();

        UserTransactionAccounts::create(array(
            'user_id' => 1,
            'balance' => 10000,
        ));
    }
}
