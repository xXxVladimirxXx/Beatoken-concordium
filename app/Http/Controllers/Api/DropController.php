<?php

namespace App\Http\Controllers\Api;

use App\Services\DropService;
use App\Http\Requests\DropRequest;
use Illuminate\Http\Request;
use App\Models\{Nft, Drop, Setting};
use Carbon\Carbon;
use Auth;

class DropController extends Controller
{
    private $dropService;

    public function __construct()
    {
        $this->middleware('role:author')->only('store');
        $this->dropService = new DropService;
    }

    public function index() {
        $drops = Drop::where(['status' => 'active'])->get();
        $dropsArray = [];
        foreach ($drops as $drop) { $dropsArray[] = $this->calculateCommissionDrop($drop); }
        return response()->json($dropsArray, 200);
    }

    public function allDropsByUser() {
        $drops = Drop::where('user_id', Auth::id())->get();
        $dropsArray = [];
        foreach ($drops as $drop) { $dropsArray[] = $this->calculateCommissionDrop($drop); }
        return response()->json($dropsArray, 200);
    }

    public function store(DropRequest $request) {
        return response()->json([
            'drop' => $this->calculateCommissionDrop($this->dropService->createDrop($request)),
            'nfts' => Nft::where('user_id', Auth::id())->with('drop')->get(),
        ], 200);
    }

    public function update(Drop $drop, Request $request) {
        $drop->setAppends([])->update($request->only(
            'name', 'release_name', 'release_start', 'release_end',
            'short_description', 'full_description', 'video_url', 'status'
        ));
        $drop = $this->calculateCommissionDrop($drop);
        return response()->json($drop);
    }

    /** @OA\Get(
     *     path="/drops/{drop_id}",
     *     summary="Returns drop by id",
     *     tags={"showDrop"},
     *     @OA\Response(response=200, description="Successful get drop")
     * ) */
    public function show(Drop $drop) {
        $drop = Drop::withCount(['nfts' => fn ($q) => $q->where('user_id', '=', $drop->user_id)])->find($drop->id);
        if ($drop->status != 'active') return response()->json([], 404);
        $drop = $this->calculateCommissionDrop($drop);
        return response()->json($drop, 200);
    }

    /** @OA\Get(
     *     path="/drops/get-highlited-drops",
     *     summary="Return Highlited drops",
     *     tags={"getHighlitedDrops"},
     *     @OA\Response(response=200, description="Successful getHighlitedDrops")
     * ) */
    public function getHighlitedDrops() {
        $active = Drop::where(function ($query) {
                        $query
                            ->where([['release_start', '<=', Carbon::parse(Carbon::now())->addMinutes(15)], ['release_end', '>=', Carbon::now()], 'status' => 'active'])
                            ->where(function ($query) { $query->has('nfts', '>' , 0); });
                  })->withCount('nfts')->without('nfts')->first();

        $expired = Drop::where(function ($query) {
                        $query
                            ->where([['release_end', '<', Carbon::now()], 'status' => 'active'])
                            ->orWhere(function ($query) { $query->has('nfts', 0); });
                    })->orderByDesc('release_end')->withCount('nfts')->without('nfts')->first();

        $active = $this->calculateCommissionDrop($active);
        $expired = $this->calculateCommissionDrop($expired);

        return response()->json(['active' => $active, 'expired' => $expired], 200);
    }

    public function calculateCommissionDrop($drop) {
        if (isset($drop->price)) {
            $commissionDrop = Setting::where('key', 'fee_drop')->pluck('value')->first();
            $drop->price = round((int) $drop->price + ($drop->price / 100 * $commissionDrop), 2);
        }
        return $drop;
    }

    public function buy(Drop $drop, Request $request) {
        return $this->dropService->buy($drop, $request);
    }

    public function destroy(Drop $drop) {
        $drop->dropLines()->delete();
        $drop->delete();
        return response()->json([], 200);
    }
}
