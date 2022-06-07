<?php

namespace App\Http\Controllers\Api;

use App\Models\{DropLine};
use App\Services\DropLineService;
use Auth;

class DropLineController extends Controller
{
    private $dropLineService;

    public function __construct() {
        $this->dropLineService = new DropLineService;
    }

    /** @OA\Get(
     *     path="/drop-lines/store-by-drop/{drop_id}",
     *     summary="storeByDrop",
     *     tags={"storeByDrop"},
     *     @OA\Response(response=200, description="Successful storeByDrop")
     * ) */
    public function storeByDrop($drop_id) {
        return $this->dropLineService->storeByDrop($drop_id);
    }

    /** @OA\Get(
     *     path="/drop-lines/my-time-to-start-buy-drop/{drop_id}",
     *     summary="myTimeToStartBuyDrop",
     *     tags={"myTimeToStartBuyDrop"},
     *     @OA\Response(response=200, description="Successful myTimeToStartBuyDrop")
     * ) */
    public function myTimeToStartBuyDrop($drop_id) {
        return $this->dropLineService->myTimeToStartBuyDrop($drop_id);
    }

    /** @OA\Get(
     *     path="/drop-lines/my-time-to-buy-drop/{drop_id}",
     *     summary="myTimeToBuyDrop",
     *     tags={"myTimeToBuyDrop"},
     *     @OA\Response(response=200, description="Successful myTimeToBuyDrop")
     * ) */
    public function myTimeToBuyDrop($drop_id) {
        return $this->dropLineService->myTimeToBuyDrop($drop_id);
    }

    /** @OA\Get(
     *     path="/drop-lines/destroy-by-drop/{drop_id}",
     *     summary="destroyByDrop",
     *     tags={"destroyByDrop"},
     *     @OA\Response(response=200, description="Successful destroyByDrop")
     * ) */
    public function destroyByDrop($drop_id) {
        return response()->json(DropLine::where(['drop_id' => $drop_id, 'user_id' => Auth::id()])->delete());
    }
}
