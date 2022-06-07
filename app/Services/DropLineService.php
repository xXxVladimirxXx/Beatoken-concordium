<?php

namespace App\Services;

use App\Models\{Setting, DropLine, Drop};
use Carbon\Carbon;
use Auth;

class DropLineService {
    public function storeByDrop($drop_id) {
        $now = Carbon::now();

        $drop = Drop::where(function ($query) use ($now) {
            $query
                ->where([['release_start', '<=', Carbon::parse(Carbon::now())->addMinutes(15)], ['release_end', '>=', $now], 'status' => 'active'])
                ->where(function ($query) { $query->has('nfts', '>' , 0); });
        })->without('nfts')->find($drop_id);

        if (!$drop) return response()->json(['redirectToDrops' => true]);

        if ($drop_line_existing = DropLine::where(['drop_id' => $drop->id, 'user_id' => Auth::id()])->first()) {
            if ($now >=  Carbon::parse($drop_line_existing->time_line)) {
                return response()->json(['redirectToBuy' => true]);
            } else {
                return response()->json(['message' => 'drop line already exist']);
            }
        }

        $lastLine = DropLine::where(['drop_id' => $drop->id])->orderBy('time_line', 'desc')->first();
        $releaseStart = Carbon::parse($drop->release_start);

        $time_drop_line = Setting::where('key', 'default_time_drop_line')->pluck('value')->first();
        $time_drop_payment = Setting::where('key', 'default_time_drop_payment')->pluck('value')->first();

        $dropListData = ['drop_id' => $drop->id, 'user_id' => Auth::id()];

        if ($lastLine && $now > $releaseStart) {
            if ($now >= Carbon::parse($lastLine->time_line)->addSeconds($time_drop_payment)) {
                DropLine::where('drop_id', $drop->id)->delete();
                $dropListData['time_line'] = $now;
            } else {
                if ($now >= Carbon::parse($lastLine->time_line)->addSeconds($time_drop_line)) {
                    $dropListData['time_line'] = $now;
                } else {
                    $dropListData['time_line'] = Carbon::parse($lastLine->time_line)->addSeconds($time_drop_line);
                }
            }
        } else {
            if ($now > $releaseStart) {
                $dropListData['time_line'] = $now;
            } else {
                $dropListData['time_line'] = ($lastLine) ? Carbon::parse($lastLine->time_line)->addSeconds($time_drop_line) : $releaseStart;
            }
        }

        $drop_line = DropLine::create($dropListData);

        if ($now >= Carbon::parse($drop_line->time_line)) return response()->json(['redirectToBuy' => true]);

        return response()->json(['message' => 'drop line created']);
    }

    public function myTimeToStartBuyDrop($drop_id) {
        if (!$myDropLine = DropLine::where(['drop_id' => $drop_id, 'user_id' => Auth::id()])->with('drop')->first())
            return response()->json(['redirectToDrop' => true]);

        if ($now = Carbon::now() >= $timeLine = Carbon::parse($myDropLine->time_line))
            return response()->json(['redirectToBuy' => true]);

        $myDropLineIndex = DropLine::where(['drop_id' => $drop_id])->orderBy('time_line', 'asc')->pluck('id')->search($myDropLine->id);

        return response()->json([
            'dropLine' => $myDropLine,
            'timeToStartBuy' => $timeLine->diffInSeconds($now),
            'myDropLineIndex' => $myDropLineIndex + 1
        ], 200);
    }

    public function myTimeToBuyDrop($drop_id) {
        if (!$myDropLine = DropLine::where(['drop_id' => $drop_id, 'user_id' => Auth::id()])->first())
            return response()->json(['redirectToDrop' => true]);

        $defaultTimeDropPayment = Setting::where('key', 'default_time_drop_payment')->pluck('value')->first();

        if ($now = Carbon::now() >= $timeLine = Carbon::parse($myDropLine->time_line)->addSeconds($defaultTimeDropPayment)) {
            $myDropLine->delete();
            return response()->json(['redirectToDrop' => true]);
        }

        if (Carbon::now() < Carbon::parse($myDropLine->time_line))
            return response()->json(['redirectToLine' => true]);

        $timeToBuy = $timeLine->diffInSeconds($now);

        return response()->json([
            'dropLine' => $myDropLine,
            'timeToBuy' => $timeToBuy
        ]);
    }
}