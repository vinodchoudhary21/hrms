<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    protected $table = 'attendances';


    protected $fillable = [
        'date',
        'check_in',
        'check_out',
        'working_hours',
        'earning_salary',
        'status',
        'mode',
    ];
    



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
