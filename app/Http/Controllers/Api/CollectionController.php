<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\CollectionRequest;
use App\Services\{CollectionService};
use App\Models\{Collection};
use Auth;

class CollectionController extends Controller
{
    public $collectionService;

    public function __construct(CollectionService $collectionService)
    {
        $this->collectionService = $collectionService;
    }

    public function index() {
        return response()->json(Collection::where(['user_id' => Auth::id()])->get(), 200);
    }

    public function store(CollectionRequest $request) {
        return $this->collectionService->createCollection($request);
    }

    public function show(Collection $collection) {
        return response()->json($collection->load('user', 'nfts'), 200);
    }

    public function showByTab($collection_id, Request $request) {
        return response()->json($this->collectionService->showByTab($collection_id, $request), 200);
    }

    public function getCollectionsNotForSale() {
        return response()->json($this->collectionService->getCollectionsNotForSale(), 200);
    }

    public function getCollectionsForSale() {
        return response()->json($this->collectionService->getCollectionsForSale(), 200);
    }

    public function getCollectionsInDrop() {
        return response()->json($this->collectionService->getCollectionsInDrop(), 200);
    }
}
