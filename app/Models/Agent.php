<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;


class Agent extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $guarded = [
        'id', '_token'
    ];

    public function bgShops()
    {
        return $this->hasMany(BgShop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function saveAgent($array,$password)
    {
        $qry = Agent::create($array);
        $user = User::where('id', $qry->user_id)->first();
        $email = $user->email;
        $id = 'agent';
        if ($user) {
            Notification::create([
                'user_id' => $user->id,
                'message' => "Hi $user->name welcome To Bilal Ganj",
            ]);
            Mail::to($email)->send(new SendEmail($user->name, $email, $id, $password));
        }
        return $qry;
    }

    public function displayAll()
    {
        $agent = Agent::all();
        return $agent;
    }

    public function displayAgent()
    {
        $agent = User::where('type', 'agent')->get();
        return $agent;
    }

    public function editAgent($array, $id)
    {
        $qry = Agent::where('user_id', $id)->first()->update($array);
        return $qry;
    }

    public function viewOderHistory()
    {
    }

    public function manageOrders()
    {
    }

    public function updateInventory()
    {
    }

}
