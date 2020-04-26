<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Notification;
use Auth;
use phpDocumentor\Reflection\Types\Null_;

class BgShop extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id', '_token'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function viewOderHistory()
    {
    }

    public function viewAccountBook()
    {
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }


    public function saveBgShop($array)
    {
        $user = BgShop::create($array);
        $admin = User::where('type', 'admin')->first();
        if ($admin) {
            Notification::create([
                'user_id' => $admin->id,
                'message' => "New Vendor $user->shop_name is Registered with User name " . $user->user()->first()->name,
                'type'=>'assign',
            ]);
        }
        return $user;
    }

    public function updateBgShop($array)
    {
        $qry = BgShop::where('user_id',$array['user_id'])->update(['shop_name' => $array['shop_name']]);
//        dd($qry);
        return $qry;
    }

    public function displayVender()
    {
        $vender = User::where('type', 'bgshop')->get();
        return $vender;
    }

    public function fetchVendor($id)
    {
        $qry = BgShop::where('agent_id',$id)->get();
        return $qry;
    }
    public function currentVendor($agent)
    {
        $qry = BgShop::where('agent_id',$agent)->first();
        return $qry;
    }

    public function fetchAssignedVendor($id)
    {
        $qry = BgShop::find($id)->update(['agent_id' => null]);
        return $qry;
    }

    public function fetchSpecificVendor($id)
    {
        $qry = BgShop::where('user_id',$id)->first();
        return $qry;
    }
    public function findId($id)
    {
        $qry = BgShop::where('user_id',$id)->first();
        return $qry;
    }

    public function fetchVendors()
    {
        $qry = BgShop::all();
        return $qry;
    }
    public function fetchVendorByShopID($id)
    {
        $qry = $qry = BgShop::where('id',$id)->first();
        return $qry;
    }

    public function assignAgentVender($agentId, $venders, $imgval)
    {
        $agent = Agent::find($agentId);
        $user = $agent->user()->first();
        for ($x = 0; $x < $imgval; $x++) {
            $vender = BgShop::find($venders[$x]);
            $qry = $vender->update(['agent_id' => $agentId]);
            if($vender->user()->first()->is_active==='No') {
                Notification::create([
                    'user_id' => $user->id,
                    'message' => "New Vendor $vender->shop_name is Assigned you verify their location",
                    'type'=>'locationVerify',
                ]);
            }else{
                Notification::create([
                    'user_id' => $user->id,
                    'message' => "New Vendor $vender->shop_name is Assigned You",
                ]);
            }

        }
        return $qry;
    }

}
