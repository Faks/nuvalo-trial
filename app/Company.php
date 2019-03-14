<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
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
class Company extends Model
{
    /**
     * Model Name
     *
     * @var string
     */
    protected $table = 'company';
    
    
    /**
     * Model Mass Assignments
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];
}
