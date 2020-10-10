<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionTypes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "type"
    ];

    public $timestamps = false;
}
