<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingRecord extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','billing_month','included_calls','extra_calls','amount_charged'];
    public function user() { return $this->belongsTo(User::class); }
}
