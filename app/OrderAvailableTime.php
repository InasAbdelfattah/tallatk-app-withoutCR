<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class OrderAvailableTime extends Model
{

    protected $table = 'order_available_times' ;

    protected $fillable = [
        'order_id' , 'day' , 'time'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
