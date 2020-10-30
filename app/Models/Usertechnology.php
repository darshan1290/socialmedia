<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usertechnology extends Model
{
    protected $table = "user_technologies";
    protected $fillable = [
        'user_id', 'tech_name'
    ];
    public function user(){
        return $this->belongsTo(User::class,'id');
     }
}
