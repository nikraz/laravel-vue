<?php

namespace App\Http\Services;

use App\Http\Repositories\TransactionsRepository;
use App\Http\Repositories\TransactionTypesRepository;
use App\Http\Repositories\UserTransactionAccountsRepository;
use Illuminate\Support\Collection;

class TransactionService extends AbstractService
{
    /** @var TransactionsRepository */
    protected $_transactionRepository;

    /** @var TransactionTypesRepository */
    protected $_transactionTypesRepository;

    /** @var UserTransactionAccountsRepository */
    protected $_userTransactionAccountsRepository;

    /**
     * @param TransactionsRepository $transactionsRepository
     * @param TransactionTypesRepository $transactionTypesRepository
     * @param UserTransactionAccountsRepository $userTransactionAccountsRepository
     */
    public function __construct(
        TransactionsRepository $transactionsRepository,
        TransactionTypesRepository $transactionTypesRepository,
        UserTransactionAccountsRepository $userTransactionAccountsRepository
)
    {
        $this->_transactionRepository = new $transactionsRepository;
        $this->_transactionTypesRepository = new $transactionTypesRepository;
        $this->_userTransactionAccountsRepository = new $userTransactionAccountsRepository;
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

    /**
     * @param $id
     * @return bool
     */
    public function removeTransactionById($id): bool
    {
        return $this->_transactionRepository->removeTransactionById($id);
    }

    /**
     * @param $request
     * @return bool
     */
    public function storeTransaction($amount, $type_id, $utc_id): bool
    {
        return $this->_transactionRepository->storeTransaction($amount, $type_id, $utc_id);
    }

    /**
     * @param $name
     * @return int
     */
    public function getUserAccountIdByUserName($name): int
    {
        return $this->_userTransactionAccountsRepository->getUserTransactionAccountIdByUserName($name);
    }

    /**
     * @param $type
     * @return int
     */
    public function getTypeId($type): int
    {
        return $this->_transactionTypesRepository->getTransactionTypesId($type);
    }
}
