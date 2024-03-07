<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return TransactionResource::collection(Transaction::with('category')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        $transactions = auth()->user()->transactions()->create($request->validated());
        // validate and then create
        return new TransactionResource($transactions);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $transaction = Transaction::find($id);
        if(!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return new TransactionResource($transaction);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, int $id)
    {

        $transaction = Transaction::find($id);
        if(!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }
        // update
        $transaction->update($request->validated());
        return new TransactionResource($transaction);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {

        $transaction = Transaction::find($id);
        if(!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // delete
        $transaction->delete();
        return response()->noContent();

    }
}
