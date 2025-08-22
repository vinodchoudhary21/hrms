<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work_home extends Model
{



    protected $table = 'work_homes';

    protected $fillable = [
        'user_id',
        'work_date',
        'start_time',
        'end_time',
        'reason',
        'location',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
