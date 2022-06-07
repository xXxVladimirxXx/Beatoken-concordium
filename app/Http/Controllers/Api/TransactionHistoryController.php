<?php

namespace App\Http\Controllers\Api;

use App\Services\TransactionHistoryService;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;

class TransactionHistoryController extends Controller
{
    protected $transactionHistoryService;

    public function __construct(TransactionHistoryService $transactionHistoryService) {
        $this->transactionHistoryService = $transactionHistoryService;
    }

    public function getByUserId($user_id) {
        return response()->json(TransactionHistory::where('user_id', $user_id)->get(), 200);
    }

    public function show(TransactionHistory $transactionHistory) {
        return response()->json($transactionHistory, 200);
    }

    public function destroy(TransactionHistory $transactionHistory) {
        return response()->json($transactionHistory->delete(), 200);
    }
}
