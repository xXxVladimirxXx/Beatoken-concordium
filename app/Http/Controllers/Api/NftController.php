<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\NftRequest;
use Illuminate\Http\Request;
use App\Services\{NftService};
use App\Models\{Nft};
use Auth;

class NftController extends Controller
{
    public $nftService;

    public function __construct(NftService $nftService)
    {
        $this->nftService = $nftService;
        $this->middleware('role:author')->only('store');
    }

    /** @OA\Get(
     *     path="/nfts",
     *     summary="Returns all nfts",
     *     tags={"getAllNfts"},
     *     @OA\Response(response=200, description="Successful getAllNfts")
     * ) */
    public function index() {
        return response()->json(Nft::where(['user_id' => Auth::id()])->with('drop')->get(), 200);
    }

    public function getNftsNotForSale() {
        return response()->json($this->nftService->getNftsNotForSale(), 200);
    }

    public function getNftsForSale() {
        return response()->json($this->nftService->getNftsForSale(), 200);
    }

    public function getNftsInDrop() {
        return response()->json($this->nftService->getNftsInDrop(), 200);
    }

    public function allNftsOfAllUsers() {
        return response()->json(Nft::with('drop', 'user')->get(), 200);
    }

    public function allNftsByUserId($user_id) {
        return response()->json(Nft::where(['user_id' => $user_id])->get(), 200);
    }

    public function store(NftRequest $request) {
        if ($request->copies) return $this->nftService->createCopiesNft($request);
        return $this->nftService->createNft($request);
    }


    /** @OA\Get(
     *     path="/nfts/{nft}",
     *     summary="Returns nft by id",
     *     tags={"getNftById"},
     *     @OA\Response(response=200, description="Successful get nft by id")
     * ) */
    public function show(Nft $nft) {
        return response()->json($nft->load('user', 'collection', 'latestDrop'), 200);
    }

    public function putForSale(Request $request) {
        $nft = Nft::find($request->id);
        if ($nft->user_id != Auth::id() && $nft->drop_id != NULL) return response()->json(['message' => 'This nft cannot be put up for sale'], 403);
        return response()->json($nft->update(['price' => $request->price]), 200);
    }

    public function removeFromSale(Nft $nft) {
        if ($nft->user_id != Auth::id() && $nft->drop_id != NULL) return response()->json(['message' => 'This nft cannot be withdrawn from sale'], 403);
        return response()->json($nft->update(['price' => NULL]), 200);
    }

    public function buy(Nft $nft, Request $request) {
        return $this->nftService->buy($nft, $request);
    }
}
