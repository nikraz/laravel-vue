<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "type_id", "account_id", "amount"
    ];
}
