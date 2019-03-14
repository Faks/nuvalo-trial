<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeWorkHours
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
class EmployeeWorkHours extends Model
{
    /**
     * Model Name
     *
     * @var string
     */
    protected $table = 'employee_work_hours';
    
    /**
     * Model Mass Assignments
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'start',
        'end'
    ];
    
    /**
     * Cast Type
     *
     * @var array
     */
    protected $dates = [
        'start',
        'end'
    ];
    
    /**
     * Mutator Getter
     *
     * @param $key $key data
     *
     * @return string
     */
    public function getStartAttribute($key)
    {
        return Carbon::parse($key)->format('H:i');
    }
    
    /**
     * Mutator Getter
     *
     * @param $key $key data
     *
     * @return string
     */
    public function getEndAttribute($key)
    {
        return Carbon::parse($key)->format('H:i');
    }
    
    /**
     * Mutator Getter
     *
     * @return float
     */
    public function getTotalHoursAttribute()
    {
        return round(Carbon::parse($this->start)->floatDiffInHours($this->end), 2);
    }
    
    /**
     * Relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
