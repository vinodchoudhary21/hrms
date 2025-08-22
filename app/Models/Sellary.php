<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sellary extends Model
{

    protected $table = 'sellaries';


    protected $fillable = [
        'month'
    ];
    



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
