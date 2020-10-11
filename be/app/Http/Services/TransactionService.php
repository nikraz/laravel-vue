<?php

namespace App\Http\Services;

use App\Http\Repositories\TransactionsRepository;
use App\Http\Repositories\TransactionTypesRepository;
use App\Http\Repositories\UsersRepository;
use App\Http\Repositories\UserTransactionAccountsRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService extends AbstractService
{
    /** @var TransactionsRepository */
    protected $_transactionRepository;

    /** @var TransactionTypesRepository */
    protected $_transactionTypesRepository;

    /** @var UserTransactionAccountsRepository */
    protected $_userTransactionAccountsRepository;

    /** @var UsersRepository */
    protected $_usersRepository;

    /**
     * @param TransactionsRepository $transactionsRepository
     * @param TransactionTypesRepository $transactionTypesRepository
     * @param UserTransactionAccountsRepository $userTransactionAccountsRepository
     * @param UsersRepository $usersRepository
     */
    public function __construct(
        TransactionsRepository $transactionsRepository,
        TransactionTypesRepository $transactionTypesRepository,
        UserTransactionAccountsRepository $userTransactionAccountsRepository,
        UsersRepository $usersRepository
)
    {
        $this->_transactionRepository = new $transactionsRepository;
        $this->_transactionTypesRepository = new $transactionTypesRepository;
        $this->_userTransactionAccountsRepository = new $userTransactionAccountsRepository;
        $this->_usersRepository = new $usersRepository;
    }

    /**
     * @param $orderBy
     * @param $orderByDir
     * @return Collection
     */
    public function getTransactionsByCriteria($orderBy, $orderByDir): Collection
    {
        return $this->_transactionRepository->getTransactionsByCriteria($orderBy, $orderByDir);
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

    /**
     * @param $transactions
     * @return array
     */
    public function addEditCellOptionToResultSet($transactions): array
    {
        $transactionsWithEditOption = [];

        foreach ($transactions as $key=>$transaction) {
            foreach ($transaction as $key2=>$val){
                $transaction->$key2 = ['value' => $val, 'edit' => false];
            }
               $transactionsWithEditOption[$key] = $transaction;
        }

        return $transactionsWithEditOption;
    }

    public function updateByType($transactionId, $type, $newValue): bool
    {
            switch ($type){
                case 'user_balance':
                    $newValue = explode(' (', $newValue);
                    $userName = $newValue[0];
                    $balance = substr($newValue[1], 0, -2);
                    DB::beginTransaction();
                        try {
                            $accountId = $this->_transactionRepository->getAccountIdById($transactionId);
                            $userId = $this->_userTransactionAccountsRepository->getUserById($accountId);
                            if ($accountId && $userId) {
                                $this->_userTransactionAccountsRepository->updateBalanceById($accountId, $balance);
                                $this->_usersRepository->updateNameById($userId, $userName);
                            }
                        } catch(\Exception $e)
                        {
                            Log::error('Issue with update user_balance! Transaction_id='. $transactionId);
                            DB::rollback();
                            return false;
                        }
                    DB::commit();

                    return true;
                case 'type':
                    $typeId = $this->_transactionTypesRepository->getTransactionTypesId($newValue);

                    if ($typeId) {
                        return $this->_transactionRepository->updateTypeById($transactionId, $typeId);
                    }

                    return false;
                case 'amount':
                  return  $this->_transactionRepository->updateAmountById($transactionId, $newValue);
             }

    }
}
