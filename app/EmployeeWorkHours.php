<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeWorkHours extends Model
{
    
    protected $table = 'employee_work_hours';
    
    
    protected $fillable = [
        'employee_id',
        'start',
        'end'
    ];
}
