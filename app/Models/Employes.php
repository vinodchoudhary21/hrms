<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Employes extends Model
{
    public function user()
    {
        return $this->hasOne(User::class, 'employee_id');
    }
}
