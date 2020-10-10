<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTransactionAccounts extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_transaction_accounts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "user_id", "balance"
    ];

    public $timestamps = false;
}
