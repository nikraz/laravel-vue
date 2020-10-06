<?php

namespace App\Http\Controllers;

use App\Http\Services\TransactionService;
use App\Transactions;
use Illuminate\Http\Request;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class TransactionsController extends Controller
{
    //get all trans
    public function index(Request $request, TransactionService $transactionService)
    {
        $orderBy = $request->input('column'); //Index
        $orderByDir = $request->input('dir', 'asc');
        $searchValue = $request->input('search');
        $transactions = $transactionService->getTransactionsByCriteria($orderBy,$orderByDir,$searchValue);

        return new DataTableCollectionResource($transactions);
    }
//post store trans
    public function store(Request $request)
    {
        $post = Transactions::create($request->all());

        return response()->json($post);
    }
//get create page
    public function create(Request $request)
    {
        $post = Transactions::create($request->all());

        return response()->json($post);
    }

    //get single trans
    public function show(Request $request)
    {
        $post = Transactions::create($request->all());

        return response()->json($post);
    }

    //put/update single trans
    public function update(Request $request)
    {
        $post = Transactions::create($request->all());

        return response()->json($post);
    }
//detete trans
    public function destroy($id)
    {
        Transactions::destroy($id);

        return response()->json("ok");
    }
    //edit single trans
    public function edit($id)
    {
        Transactions::destroy($id);

        return response()->json("ok");
    }
}
