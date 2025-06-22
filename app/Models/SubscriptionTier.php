<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionTier extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'daily_limit',
        'extra_call_cost'
    ];
    public function users() 
    {
        return $this->hasMany(User::class); 
    } 
}
