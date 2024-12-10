<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'user_id','username','password','user_position','user_posid','sponser_id','name','email',
        'mobile','address','package','use_pin','conform_password','profile_pic','status','commission_account',
    ];

    public function leftChild()
    {
        return $this->hasOne(User::class, 'user_posid', 'user_id')
                    ->where('user_position', 'L');
    }

    public function rightChild()
    {
        return $this->hasOne(User::class, 'user_posid', 'user_id')->where('user_position', 'R');
    }
    public function children()
{
    return $this->hasMany(User::class, 'user_posid', 'user_id');
}

    public function parent()
    {
        return $this->belongsTo(User::class, 'user_posid', 'id');
    }
    public function updateCommission($amount)
    {
        $this->commission_account -= $amount;
        $this->save();
    }

        public function addBonus($bonus)
    {
        $this->commission_account += $bonus;
        $this->save();
    }

}
