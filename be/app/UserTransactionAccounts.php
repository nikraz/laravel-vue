<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTransactionAccounts extends Model
{
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
