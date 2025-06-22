<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;

use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Passport;  // For some setup (optional)

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   /* protected $fillable = [
        'name',
        'email',
        'password',
    ];*/

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
   /* protected $hidden = [
        'password',
        'remember_token',
    ];*/

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    /*protected $casts = [
        'email_verified_at' => 'datetime',
    ];*/

    protected $fillable = ['name','email','password','subscription_tier_id'];
    protected $hidden = ['password','remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function subscriptionTier() { return $this->belongsTo(SubscriptionTier::class); }
    public function usageCounters() { return $this->hasMany(ApiUsageCounter::class); }
    public function billingRecords() { return $this->hasMany(BillingRecord::class); }
}
