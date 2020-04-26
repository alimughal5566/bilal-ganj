<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

class Rider extends Model
{
    use SoftDeletes;

    protected $guarded = [
        'id', '_token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function riderLog(){
        return $this->belongsTo(RiderLog::class);
    }

    public function saveRider($array, $password)
    {
        $qry = Rider::create($array);
        $user = User::where('id', $qry->user_id)->first();
        $email = $user->email;
        $id = 'rider';
        if ($user) {
            Notification::create([
                'user_id' => $user->id,
                'message' => "Hi $user->name welcome To Bilal Ganj",
            ]);
            Mail::to($email)->send(new SendEmail($user->name, $email, $id, $password));
        }
        return $qry;
    }

    public function deleteRider($id)
    {
        $user = User::find($id);
        $rider = Rider::where('user_id', $id)->first();
        $user->update(['is_active' => 'no']);
        $qry1 = $rider->delete();
        $qry = $user->delete();
    }

    public function fetchRiders()
    {
        return Rider::all();
    }

    public function updateRider($userTableAttr, $id)
    {
        $qry = User::where('id', $id)->update([
            'name' => $userTableAttr['name'],
            'email' => $userTableAttr['email'],
            'address' => $userTableAttr['address'],
            'latitude' => $userTableAttr['latitude'],
            'longitude' => $userTableAttr['longitude'],
            'contact_number' => $userTableAttr['contact_number'],

        ]);
        return $qry;
    }

    public function editRider($array, $id)
    {
        $qry = Rider::where('user_id', $id)->first()->update($array);
        return $qry;
    }
}
