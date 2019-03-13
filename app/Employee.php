<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';
    
    protected $fillable = [
        'company_id',
        'fname',
        'lname',
        'email',
        'phone',
        'address',
    ];
}
