<?php

use Illuminate\Database\Seeder;
use App\TransactionTypes;

class TransactionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaction_types')->truncate();

        TransactionTypes::create(array(
            'type' => 'Credit Card',
        ));
        TransactionTypes::create(array(
            'type' => 'Debit Card',
        ));
    }
}
