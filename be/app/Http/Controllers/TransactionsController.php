<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteTransaction;
use App\Http\Requests\StoreTransaction;
use App\Http\Requests\UpdateTransaction;
use App\Http\Services\TransactionService;
use App\Transactions;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index(Request $request, TransactionService $transactionService)
    {
        //TODO remove search and columns dir
        $orderBy = $request->input('column', 'id'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $transactions = $transactionService->getTransactionsByCriteria($orderBy,$orderByDir);
        $transactions = $transactionService->addEditCellOptionToResultSet($transactions);

        return  response()->json($transactions);
    }

    public function store(StoreTransaction $request, TransactionService $transactionService)
    {
        $amount = $request->get('amount');
        $utcId = $transactionService->getUserAccountIdByUserName($request->get('name'));
        $typeId = $transactionService->getTypeId($request->get('type'));

        //TODO shoudl be related to user_Transactions_accounts and there is no unique field there as ther could be multiple accounts per user,
        //For task we only take first from that table (As default) based on user name when creating transasction
        $transactionService->storeTransaction($amount, $typeId, $utcId);

        return response()->json("ok", 201);
    }

    public function update($id, UpdateTransaction $request, TransactionService $transactionService)
    {
        $transactionService->updateByType($id, $request->get('type'), $request->get('value'));

        return response()->json("ok", 200);
    }

    public function destroy($id, TransactionService $transactionService)
    {
        $transactionService->removeTransactionById($id);

        return response()->json("ok", 204);
    }
}
