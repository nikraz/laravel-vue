<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionTypes extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "types"
    ];

    public $timestamps = false;
}
