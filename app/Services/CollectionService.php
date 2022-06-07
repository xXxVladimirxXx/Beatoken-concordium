<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\{Collection};
use App\Traits\Eloquent\Uploadable;
use Auth;

class CollectionService
{
    private $notForSaleQuery;
    private $forSaleQuery;
    private $inDropQuery;

    public function __construct()
    {
        $this->notForSaleQuery = function ($query) {
            $query
                ->where(['user_id' => Auth::id(), 'price' => null, 'drop_id' => null])
                ->orWhere(function ($orQuery) {
                    $orQuery
                        ->where(['user_id' => Auth::id(), 'price' => null])
                        ->whereHas('drop', function ($queryRelation){
                            $queryRelation
                                ->where(function ($dateQuery){
                                    $dateQuery
                                        ->where('release_start', '<', Carbon::now())
                                        ->where('release_end', '<', Carbon::now());
                                })
                                ->orWhere(function ($dateQuery){
                                    $dateQuery
                                        ->where('release_start', '>', Carbon::now())
                                        ->where('release_end', '>', Carbon::now());
                                });
                        });
                });
        };

        $this->forSaleQuery = function ($query) { $query->where([['price', '!=', null], ['user_id', Auth::id()]]); };

        $this->inDropQuery = function ($query) {
            $query
                ->where(function ($orQuery) {
                    $orQuery
                        ->where(['user_id' => Auth::id(), 'price' => null])
                        ->whereHas('drop', function ($query){
                            $query
                                ->where('release_start', '<', Carbon::now())
                                ->where('release_end', '>', Carbon::now());
                        });
                });
        };
    }

    public function createCollection($request) {

        $сollectionData = $request->only('name', 'description');
        $сollectionData['cover_image'] = 'before_save_cover';
        $сollectionData['user_id'] = Auth::id();
        $сollection = Collection::create($сollectionData);

        // Save the cover image
        $cover_image = Uploadable::uploadPhoto($request->cover_image,
            'cover_'.$сollection->id.'.' . $request->file('cover_image')->getClientOriginalExtension(),
            Auth::id() . '_user_collections'
        );

        $сollection->cover_image = $cover_image;
        $сollection->save();

        return response()->json($сollection, 200);
    }

    public function getCollectionsNotForSale() {
        return Collection::whereHas('nfts', $this->notForSaleQuery)->get();
    }

    public function getCollectionsForSale() {
        return Collection::whereHas('nfts', $this->forSaleQuery)->get();
    }

    public function getCollectionsInDrop() {
        return Collection::whereHas('nfts', $this->inDropQuery)->get();
    }

    public function showByTab($collection_id, $request) {
        if ($request->notForSale) $query = $this->notForSaleQuery;
        if ($request->forSale) $query = $this->forSaleQuery;
        if ($request->inDrop) $query = $this->inDropQuery;

        return Collection::with(['nfts' => $query])->find($collection_id);
    }
}