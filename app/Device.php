<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['user_id', 'device'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
