<?php

namespace App\Http\Repositories;
use App\TransactionTypes;
use Illuminate\Support\Collection;

class TransactionTypesRepository extends AbstractRepository
{
    /**
     * @param $type
     * @return int
     */
    public function getTransactionTypesId($type): int
    {
        return TransactionTypes::where('type', $type)->first()->id;
    }
}
