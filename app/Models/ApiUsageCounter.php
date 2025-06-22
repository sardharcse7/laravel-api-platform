<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiUsageCounter extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','date','calls_count'];
    public function user() { return $this->belongsTo(User::class); } 
}
