<?php

namespace App\Models;


//use Illuminate\Http\Request;
//use App\Models\Notification;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Str;
//use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens, Notifiable;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * @var array
     */
    protected $guarded = [
        'id', '_token'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Override parent boot and Call deleting event
     *
     * @return void
     */
    public function hasRole($role)
    {
        return $role;
    }

    public function bgShop()
    {
        return $this->hasOne(BgShop::class);
    }

    public function wishList()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    public function rider()
    {
        return $this->hasOne(Rider::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function saveUser($user)
    {
        $securePassword = Hash::make($user['password']);
        $qry = User::create(['name' => $user['name'], 'email' => $user['email'], 'password' => $securePassword, 'contact_number' => $user['contact_number'], 'address' => $user['address'], 'latitude' => $user['latitude'], 'longitude' => $user['longitude'], 'is_active' => 'No']);
        if ($qry) {
            Notification::create([
                'user_id' => $qry->id,
                'message' => "Hi $qry->name welcome To Bilal Ganj",
            ]);
        }
        return $qry;
    }

    public function forgetPasswordDone($email, $password)
    {
        $securePassword = Hash::make($password);
        $user = User::where('email', $email)->first()->update(['password' => $securePassword]);
        return $user;
    }

    public function forgetPassword($email)
    {
        $qry = User::where('email', $email)->first();
        return $qry;
    }

    public function saveVendor($userTableAttr)
    {
        $hashPassword = Hash::make($userTableAttr['password']);
        $user = User::create(array_merge($userTableAttr, ['password' => $hashPassword, 'type' => 'bgshop', 'is_active' => 'No']));
        return $user;

    }

    public function updateUser($formdata)
    {
        $qry = User::where('email', $formdata['email'])->first()->update($formdata);
        return $qry;
    }

    public function fetchUserType()
    {
        $qry = User::where('type', 'user')->get();
        return $qry;
    }

    public function updatePassword($formdata)
    {
        $user = User::where('id', $formdata['user_id'])->first();
        if ($user && Hash::check($formdata['old_password'], $user->password)) {
            $user->password = Hash::make($formdata['password']);
            $qry = $user->save();
            return $qry;
        }
    }

    public function updatedVendorPassword($formdata)
    {
        $vendor = User::where('id', $formdata['user_id'])->first();
        if ($vendor && Hash::check($formdata['old_password'], $vendor->password)) {

            $vendor->password = Hash::make($formdata['password']);
            $qry = $vendor->save();
            return $qry;
        }
    }

    public function updatedVendorProfile($formdata)
    {
        $vendor = User::where('email', $formdata['email'])->first()->update($formdata);
        return $vendor;
    }

    public function updateAdminProfile($formdata)
    {
        $admin = User::where('email', $formdata['email'])->first()->update($formdata);
        return $admin;
    }

    public function updateAdminPassword($formdata)
    {
        $user = User::where('id', $formdata['user_id'])->first();
        if ($user && Hash::check($formdata['old_password'], $user->password)) {

            $user->password = Hash::make($formdata['password']);
            $qry = $user->save();
            return $qry;
        }
    }

    public function fetchUsers()
    {

        $user = User::withTrashed()->get();
        return $user;
    }

    public function getEmailUser($email)
    {
        $qry = User::where('email', $email)->first()->update(['is_active' => 'Yes']);
        $user = User::where('email', $email)->first();
        return $user;
    }

    public function updateStatus($user)
    {
        $status = User::where('id', $user->id)->first()->update(['is_active' => 'Yes']);
        $bgShop = $user->bgShop()->first();
        $agent = $bgShop->agent()->first();
        $agentUserId = $agent->user()->first()->id;
        if ($user) {
            Notification::create([
                'user_id' => $user->id,
                'message' => "Congrats Your Account is activated",
            ]);
            Notification::create([
                'user_id' => $agentUserId,
                'message' => 'You have got it a new Vendor',
                'type'=>'agentPanel'
            ]);
        }
        return $status;
    }

    public function search()
    {
    }

    public function viewProfile()
    {
    }

    public function updateProfile()
    {
    }

    public function resetPassword()
    {
    }

    public function placeOrder()
    {
    }

    public function viewNotifications()
    {
    }

    public function giveReviews()
    {
    }

    public function manageUser()
    {
    }

    public function notifyUser()
    {
    }

    public function addAgent()
    {
    }

    public function viewOderHistory()
    {
    }

    public function saveAgent($userTableAttr, $password)
    {
        $hashPass = Hash::make($password);
        $userQry = User::create(array_merge($userTableAttr, ['password' => $hashPass, 'type' => 'agent', 'is_active' => 'yes']));
        return $userQry;
    }

    public function saveRider($userTableAttr, $password)
    {

        $hashPass = Hash::make($password);
        $userQry = User::create(array_merge($userTableAttr, ['password' => $hashPass, 'type' => 'rider', 'is_active' => 'yes']));
        return $userQry;
    }

    public function updateAgent($userTableAttr, $id)
    {
        $qry = User::where('id', $id)->update(['name' => $userTableAttr['name'], 'email' => $userTableAttr['email'], 'address' => $userTableAttr['address'], 'contact_number' => $userTableAttr['contact_number'], 'latitude' => $userTableAttr['latitude'], 'longitude' => $userTableAttr['longitude']]);
        return $qry;
    }

    public function fetchSpecificUser($id)
    {
        $user = User::withTrashed()->find($id);
        return $user;
    }


    public function approveAdds()
    {
    }

    public function confirmBgshop()
    {
    }

    public function destoryAgent($id)
    {
        $user = $this::find($id);
        $agent = Agent::where('user_id', $id)->first();
        $user->update(['is_active' => 'no']);
        $null = BgShop::where('agent_id', $agent->id)->update(['agent_id' => null]);
        $qry1 = $agent->delete();
        $qry = $user->delete();
    }
}
