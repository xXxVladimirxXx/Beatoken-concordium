<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\{TransactionHistory};
use Auth;

class TransactionHistoryService {

    public function whenUserBoughtNft($nft, $request) {

        //NFT
        $nftTransaction = [
            'description' => 'NFT transaction',
            'amount' => 1,
            'type' => 'Out',
            'date' => Carbon::now(),
            'orderId' => $request->id,
            'details' => $nft->metadata->name,
            'user_id' => $nft->user_id,
        ];
        TransactionHistory::create($nftTransaction);

        $nftTransaction['type'] = 'In';
        $nftTransaction['user_id'] = Auth::id();

        TransactionHistory::create($nftTransaction);
    }
}
