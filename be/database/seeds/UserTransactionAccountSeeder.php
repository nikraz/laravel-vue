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

        foreach(range(1, 10) as $index)
        {
            UserTransactionAccounts::create(array(
                'user_id' => $index,
                'balance' => 10000,
            ));
        }
    }
}
