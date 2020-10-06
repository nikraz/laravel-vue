<?php

namespace App\Http\Services;

use App\Http\Repositories\TransactionsRepository;
use Illuminate\Support\Collection;

class TransactionService extends AbstractService
{
    /** @var TransactionsRepository */
    protected $_transactionRepository;

    /**
     * @param TransactionsRepository $transactionsRepository
     */
    public function __construct(TransactionsRepository $transactionsRepository)
    {
        $this->_transactionRepository = new $transactionsRepository;
    }

    /**
     * @param $orderBy
     * @param $orderByDir
     * @param $searchValue
     * @return Collection
     */
    public function getTransactionsByCriteria($orderBy, $orderByDir, $searchValue): Collection
    {
        return $this->_transactionRepository->getTransactionsByCriteria($orderBy, $orderByDir, $searchValue);
    }
}
