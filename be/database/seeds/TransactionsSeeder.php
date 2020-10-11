<?php

use Illuminate\Database\Seeder;
use App\Transactions;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions')->truncate();

        Transactions::create(array(
            'account_id' => 1,
            'amount' => 100,
            'type_id' => 1,
        ));
        Transactions::create(array(
            'account_id' => 1,
            'amount' => 100,
            'type_id' => 1,
        ));
        Transactions::create(array(
            'account_id' => 4,
            'amount' => 100,
            'type_id' => 2,
        ));
        Transactions::create(array(
            'account_id' => 6,
            'amount' => 100,
            'type_id' => 2,
        ));
        Transactions::create(array(
            'account_id' => 2,
            'amount' => 100,
            'type_id' => 1,
        ));
        Transactions::create(array(
            'account_id' => 3,
            'amount' => 150,
            'type_id' => 2,
        ));
        Transactions::create(array(
            'account_id' => 2,
            'amount' => 150,
            'type_id' => 2,
        ));
    }
}
