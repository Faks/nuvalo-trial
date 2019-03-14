<?php

namespace App;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 * Created by PhpStorm.
 * User: Faks
 * GitHub: https://github.com/Faks
 *
 * @category PHP
 * @package  App
 * @author   Oskars Germovs <solumdesignum@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT Licence
 * @link     http://solum-designum.com
 * Date: 2019.03.13.
 * Time: 10:00
 */
class Employee extends Model
{
    /**
     * Model Name
     *
     * @var string
     */
    protected $table = 'employee';
    
    /**
     * Model Mass Assignments
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'fname',
        'lname',
        'email',
        'phone',
        'address',
    ];
    
    /**
     * Relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    /**
     * Relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function workhours()
    {
        return $this->belongsTo(EmployeeWorkHours::class, 'id', 'employee_id');
    }
    
    /**
     * Scope Filter
     *
     * @param $query $query data
     *
     * @return mixed
     */
    public function scopeFilterEmployee($query)
    {
        if (!empty(request()->get('name'))) {
            foreach (explode(' ', request()->get('name')) as $name) {
                $query->where('fname', 'LIKE', '%' . $name . '%');
                $query->orwhere('lname', 'LIKE', '%' . $name . '%');
            }
        }
        
        return $query;
    }
    

    /**
     * Scope Filter
     *
     * @param $query $query data
     *
     * @return mixed
     */
    public function scopeFilterRange($query)
    {
        if (!empty(request()->get('from')) && !empty(request()->has('till'))) {
            $query->whereBetween(
                DB::raw("DATE_FORMAT(employee_work_hours.start, '%Y-%m-%d')"),
                [
                    Carbon::parse(request()->get('from'))->format('Y-m-d'),
                    Carbon::parse(request()->get('till'))->format('Y-m-d')
                ]
            );
            
            $query->whereBetween(
                DB::raw("DATE_FORMAT(employee_work_hours.end, '%Y-%m-%d')"),
                [
                    Carbon::parse(request()->get('from'))->format('Y-m-d'),
                    Carbon::parse(request()->get('till'))->format('Y-m-d')
                ]
            );
        }
        
        return $query;
    }
}
