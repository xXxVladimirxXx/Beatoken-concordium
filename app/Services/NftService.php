<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\{Collection, Nft, Setting, User};
use App\Traits\Eloquent\Uploadable;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Auth;

class NftService {
    public function createNft($request) {
        try {
            $nftData = $request->only('name', 'description', 'price');

            // Save the main token file
            $ipfs_hash = (new IPFSService)->add(file_get_contents($request->file));
            $uri_file = Uploadable::uploadPhoto($request->file,
                $ipfs_hash . '.' . $request->file('file')->getClientOriginalExtension(),
                Auth::id() . '_user_nfts'
            );

            // Save the cover image
            $nftData['cover_image'] = Uploadable::uploadPhoto($request->cover_image,
                $ipfs_hash . '_cover.' . $request->file('cover_image')->getClientOriginalExtension(),
                Auth::id() . '_user_nfts/covers'
            );

            if ($request->cover_video) {
                $nftData['cover_video'] = Uploadable::uploadPhoto($request->cover_video,
                    $ipfs_hash . '_cover.' . $request->file('cover_video')->getClientOriginalExtension(),
                    Auth::id() . '_user_nfts/covers_video'
                );
            }

            if ($request->attachment_file) {
                $nftData['attachment_file'] = Uploadable::uploadPhoto($request->attachment_file,
                    $ipfs_hash . '_attachment.' . $request->file('attachment_file')->getClientOriginalExtension(),
                    Auth::id() . '_user_nfts/attachment_file'
                );
            }

            $nftData['ipfs_hash'] = $ipfs_hash;
            $nftData['uri_file'] = $uri_file;
            $nftData['token_uri'] = env('URL_API_TOKEN_METADATA');
            $nftData['user_id'] = Auth::id();

            $nft = Nft::create($nftData);
            $nft->token_uri = $nft->token_uri . $nft->id;
            $nft->save();

            $attributes = [];
            if ($request->type) $attributes[] = ['attribute_template' => 'cube', 'attribute_type' => 'type', 'attribute_value' => $request->type];
            if ($request->attachment) $attributes[] = ['attribute_template' => 'cube', 'attribute_type' => 'attachment', 'attribute_value' => $request->attachment];
            $attributes[] = ['attribute_template' => 'cube', 'attribute_type' => 'author', 'attribute_value' => Auth::user()->name];

            (new ApiMetadata)->createMetadata($nft, $nftData, $attributes);

        } catch (\Exception $e) {
            if (isset($nft)) $nft->delete();
            return response()->json($e->getMessage(), 500);
        }

        return response()->json(Nft::where('user_id', Auth::id())->get(), 200);
    }

    public function createCopiesNft($request) {
        try {
            if ($request->copies > 1000) { return response()->json([], 500); }

            $nftData = $request->only('name', 'description', 'collection_id');

            // Save the main token file
            $ipfs_hash = (new IPFSService)->add(file_get_contents($request->file));
            $uri_file = Uploadable::uploadPhoto($request->file,
                $ipfs_hash . '.' . $request->file('file')->getClientOriginalExtension(),
                Auth::id() . '_user_nfts'
            );

            // Save the cover image
            $nftData['cover_image'] = Uploadable::uploadPhoto($request->cover_image,
                $ipfs_hash . '_cover.' . $request->file('cover_image')->getClientOriginalExtension(),
                Auth::id() . '_user_nfts/covers'
            );

            if ($request->cover_video) {
                // Save the cover video
                $nftData['cover_video'] = Uploadable::uploadPhoto($request->cover_video,
                    $ipfs_hash . '_cover.' . $request->file('cover_video')->getClientOriginalExtension(),
                    Auth::id() . '_user_nfts/covers_video'
                );
            }

            if ($request->attachment_file) {
                $nftData['attachment_file'] = Uploadable::uploadPhoto($request->attachment_file,
                    $ipfs_hash . '_attachment.' . $request->file('attachment_file')->getClientOriginalExtension(),
                    Auth::id() . '_user_nfts/attachment_file'
                );
            }

            $nftData['ipfs_hash'] = $ipfs_hash;
            $nftData['uri_file'] = $uri_file;
            $nftData['token_uri'] = env('URL_API_TOKEN_METADATA');
            $nftData['user_id'] = Auth::id();

            if (!$request->collection_id) {
                $collection = Collection::create([
                    'cover_image' => $nftData['cover_image'],
                    'name' => $request->name,
                    'description' => $request->description,
                    'user_id' => Auth::id()
                ]);
                $nftData['collection_id'] = $collection->id;
            }

            for ($nftIndex = 1; $nftIndex <= $request->copies; $nftIndex++) {
                $nft = Nft::create($nftData);
                $nft->token_uri = $nft->token_uri . $nft->id;
                $nft->save();

                $attributes = [];
                if ($request->type) $attributes[] = ['attribute_template' => 'cube', 'attribute_type' => 'type', 'attribute_value' => $request->type];
                if ($request->attachment) $attributes[] = ['attribute_template' => 'cube', 'attribute_type' => 'attachment', 'attribute_value' => $request->attachment];
                $attributes[] = ['attribute_template' => 'cube', 'attribute_type' => 'author', 'attribute_value' => Auth::user()->name];
                $attributes[] = ['attribute_template' => 'cube', 'attribute_type' => 'numbering', 'attribute_value' => "#$nftIndex / $request->copies"];

                (new ApiMetadata)->createMetadata($nft, $nftData, $attributes);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return response()->json(Nft::where('user_id', Auth::id())->get(), 200);
    }

    public function getNftsNotForSale() {
        return Nft::
                where([['price', null], ['user_id', Auth::id()], ['collection_id', null]])
                ->where(function($q) {
                    $q->whereRelation('drop', 'release_end', '<=', Carbon::now())
                        ->orWhere('drop_id', null);
                })->orderBy('drop_id')->get();
    }

    public function getNftsForSale() {
        return Nft::where([['price', '!=', null], ['user_id', Auth::id()], ['collection_id', null]])->get();
    }

    public function getNftsInDrop() {
        return Nft::
                whereRelation(
                    'drop', 'release_end', '>=', Carbon::now()
                )->where([['user_id', Auth::id()], ['collection_id', null]])->get();
    }

    public function buy($nft, $request) {
        if ($nft->user_id == Auth::id()) return response()->json(['message' => 'You can\'t buy your nft. Refresh the page and contact technical support, your money will be returned'], 403);

        $client = new PayPalClient;
        $client->setApiCredentials(config('paypal'));
        $client->setAccessToken($client->getAccessToken());
        $result = $client->showOrderDetails($request->id);

        if ($result['status'] == 'COMPLETED') {

            $transactionHistoryService = new TransactionHistoryService;
            $transactionHistoryService->whenUserBoughtNft($nft, $request);

            // balance update
            $commission = $nft->price / 100 * ((int) $nft->user->fee_sale_marketplace + (int) Setting::where('key', 'fee_marketplace')->pluck('value')->first()); // consider the commission
            $middleman = User::where('role_id', 5)->first();
            $middleman->balance = $middleman->balance + $commission;
            $middleman->save();

            $nft->user->balance = $nft->user->balance + ($nft->price - $nft->price / 100 * ((int) $nft->user->fee_sale_marketplace));
            $nft->user->save();

            $nft->update(['user_id' => Auth::id(), 'price' => NULL]);

            return response()->json($nft, 200);
        } else {
            return response()->json($nft, 402);
        }
    }
}