<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RiderLog extends Model
{
    protected $guarded = [
        'id', '_token'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function riders()
    {
        return $this->hasMany(Rider::class);
    }

    public function calculateDistance($riders, $request)
    {
        $temp = 0;
        $riderId = 0;
        $requiredDistance= 0;
        foreach ($riders as $rider) {
            $ride = RiderLog::where('rider_id', $rider->id)->where('status', 1)->first();
            $riderLat = $ride->rider_latitude;
            $riderLng = $ride->rider_longitude;
            $userLat = $ride->destination_latitude;
            $userLng = $ride->destination_longitude;
            $marketLat = $ride->origin_latitude;
            $marketLng = $ride->origin_longitude;

            $riderToUser = DB::table('rider_logs')
                ->selectRaw("*,
                ( 6371 * acos( cos( radians(" . $riderLat . ") ) *
                cos( radians($userLat) ) *
                cos( radians($userLng) - radians(" . $riderLng . ") ) + 
                sin( radians(" . $riderLat . ") ) *
                sin( radians($userLat) ) ) ) 
                AS distance")
                ->where('rider_id', $rider->id)
                ->where('status', 1)
                ->first();
//            dd($riderToUser);
            $userToMarket = DB::table('rider_logs')
                ->selectRaw("*,
                ( 6371 * acos( cos( radians(" . $userLat . ") ) *
                cos( radians($marketLat) ) *
                cos( radians($marketLng) - radians(" . $userLng . ") ) + 
                sin( radians(" . $userLat . ") ) *
                sin( radians($marketLat) ) ) ) 
                AS distance")
                ->where('rider_id', $rider->id)
                ->where('status', 1)
                ->first();

            $riderToDes = DB::table('rider_logs')
                ->selectRaw("*,
                ( 6371 * acos( cos( radians(" . $marketLat . ") ) *
                cos( radians($request->latitude) ) *
                cos( radians($request->longitude) - radians(" . $marketLng . ") ) + 
                sin( radians(" . $marketLat . ") ) *
                sin( radians($request->latitude) ) ) ) 
                AS distance")
                ->where('rider_id', $rider->id)
                ->where('status', 1)
                ->first();

            $totalDistance = $riderToUser->distance + $riderToDes->distance + $userToMarket->distance;
//                            dd($totalDistance);
            if ($temp < $totalDistance) {
                $temp = $totalDistance;
                $riderId = $rider->id;
                $requiredDistance = $userToMarket;
            }
        }
        return [
            'rider_id' => $riderId,
            'distance' => $requiredDistance
        ];
    }

    function createLog($request, $order, $rider)
    {
        $qry = RiderLog::create([
            'rider_id' => $rider->id,
            'order_id' => $order->id,
            'status' => 0,
            'origin_latitude' => $request->vendorLati,
            'origin_longitude' => $request->vendorLongi,
            'destination_latitude' => $request->latitude,
            'destination_longitude' => $request->longitude,
            'rider_latitude' => $request->vendorLati,
            'rider_longitude' => $request->vendorLongi
        ]);
        return $qry;
    }
}
