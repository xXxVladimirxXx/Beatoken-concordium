<?php

namespace App\Services;

use Carbon\Carbon;
use App\Traits\Eloquent\Uploadable;
use App\Models\{Drop, DropLine, Nft, Setting, User};
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Auth;

class DropService {
    public function createDrop($request) {
        $cover_url = Uploadable::uploadPhoto($request->cover_image,
            $request->file('cover_image')->getClientOriginalName(),
            Auth::id() . '_user_drops'
        );

        $dropData = $request->only(
            'name', 'release_name', 'price', 'short_description',
            'full_description', 'video_url', 'number_nfts', 'status'
        );
        $dropData['user_id'] = Auth::id();
        $dropData['cover_image'] = $cover_url;

        if ((int) $request->utc_user < 0) {
            $dropData['release_start'] = Carbon::parse($request->release_start)->addMinute($request->utc_user);
            $dropData['release_end'] = Carbon::parse($request->release_end)->addMinute($request->utc_user);
        } else {
            $dropData['release_start'] = Carbon::parse($request->release_start)->subMinute(abs($request->utc_user));
            $dropData['release_end'] = Carbon::parse($request->release_end)->subMinute(abs($request->utc_user));
        }

        $drop = Drop::create($dropData);

        Nft::whereIn('id', json_decode($request->idNftsForDrop))->update(['drop_id' => $drop->id, 'latest_drop_id' => $drop->id]);

        return $drop;
    }

    public function buy($drop, $request) {

        $dropArray = Drop::
            with(['nfts' => fn ($q) => $q->where('user_id', '=', $drop->user_id)])
            ->find($drop->id)->toArray();

        $client = new PayPalClient;
        $client->setApiCredentials(config('paypal'));
        $client->setAccessToken($client->getAccessToken());
        $result = $client->showOrderDetails($request->id);

        if ($result['status'] == 'COMPLETED') {

            $ids = [];
            while ($dropArray['number_nfts'] > count($ids)) {
                $nftId = $dropArray['nfts'][array_rand($dropArray['nfts'])]['id'];
                if (!is_int(array_search($nftId, $ids))) { // Check if there are duplicate id's and push

                    $nft = Nft::find($nftId);

                    $transactionHistoryService = new TransactionHistoryService;
                    $transactionHistoryService->whenUserBoughtNft($nft, $request);

                    $nft->update(['user_id' => Auth::id(), 'drop_id' => NULL, 'price' => NULL]);
                    $ids[] = $nftId;
                }
            }

            // balance update
            $commission = $drop->price / 100 * ((int) $drop->user->fee_sale_drop + (int) Setting::where('key', 'fee_drop')->pluck('value')->first()); // consider the commission

            $middleman = User::where('role_id', 5)->first();
            $middleman->balance = $middleman->balance + $commission;
            $middleman->save();

            $drop->user->balance = $drop->user->balance + ($drop->price - $drop->price / 100 * ((int) $drop->user->fee_sale_drop));
            $drop->user->save();

            DropLine::where(['drop_id' => $drop->id, 'user_id' => Auth::id()])->delete();

            return response()->json($drop, 200);
        } else {
            return response()->json($drop, 402);
        }
    }
}