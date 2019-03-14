<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeeWorkHours;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use function compact;
use function round;

/**
 * Class FilterController
 * Created by PhpStorm.
 * User: Faks
 * GitHub: https://github.com/Faks
 *
 * @category PHP
 * @package  App\Http\Controllers
 * @author   Oskars Germovs <solumdesignum@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT Licence
 * @link     http://solum-designum.com
 * Date: 2019.03.13.
 * Time: 10:40
 */
class FilterController extends Controller
{
    /**
     *  Render View
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexFilter()
    {
        $model_employee = Employee::query()
            ->FilterEmployee()
            ->leftJoin(
                'employee_work_hours',
                'employee_work_hours.employee_id',
                '=',
                'employee.id'
            )
            ->leftJoin(
                'company',
                'company.id',
                '=',
                'employee.company_id'
            )
            ->FilterRange()
            ->with(
                [
                    'company',
                    'workhours'
                ]
            )
            ->orderByDesc('employee.id')
            ->paginate(20);
        
        return view('filter', compact('model_employee'));
    }
    
    /**
     *  Render View
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexFilter2()
    {
        /* Basic Version
        $year_months = [];
        //Building Years Month Names
        for ($x = 1; $x <= 12; $x++) {
            $year_months[] = date("Y-m", strtotime("$x/12/18"));
        }

        $each_month_total_hours = [];
        $dates_and_hours = [];
        foreach ($year_months as $month) {

            $model_employee_work_hours = EmployeeWorkHours::query()
                ->with(['employee.company'])
                ->where(DB::raw("DATE_FORMAT(employee_work_hours.start, '%Y-%m')"), '=', $month)
                ->get();

            foreach ($model_employee_work_hours as $hour) {
                $dates_and_hours[] = [
                    Carbon::parse($hour->getOriginal('start'))->format('Y-m') => $hour->total_hours,
                ];
            }

            $total_hours_each_day_in_month = collect($dates_and_hours)->where($month)->flatMap(
                function ($value) use ($month) {
                    return Arr::flatten($value);
                }
            )->sum();

            $each_month_total_hours[Carbon::parse($month)->format('M Y')] = $total_hours_each_day_in_month;
        }
        */
        
        return view('filter2');
    }
    
    /**
     *  Render View
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexFilter3()
    {
        $model_employee_work_hours = EmployeeWorkHours::query()
            ->with(['employee.company'])
            ->orderBy(
                'id',
                (request()->has('filter')) ? request()->get('filter') : 'desc'
            )
            ->paginate(20);
        
        return view('filter3', compact('model_employee_work_hours'));
    }
    
    
    /**
     *  Axio Endpoint
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter2Json()
    {
        $year_months = [];
        //Building Years Month Names
        for ($x = 1; $x <= 12; $x++) {
            $year_months[] = date("Y-m", strtotime("$x/12/18"));
        }
    
        $each_month_total_hours = [];
        $dates_and_hours = [];
        foreach ($year_months as $month) {
            $model_employee_work_hours = EmployeeWorkHours::query()
                ->with(['employee.company'])
                ->where(DB::raw("DATE_FORMAT(employee_work_hours.start, '%Y-%m')"), '=', $month)
                ->get();
        
            foreach ($model_employee_work_hours as $hour) {
                $dates_and_hours[] = [
                    Carbon::parse($hour->getOriginal('start'))->format('Y-m') => $hour->total_hours,
                ];
            }
        
            $total_hours_each_day_in_month = collect($dates_and_hours)->where($month)->flatMap(
                function ($value) use ($month) {
                    return Arr::flatten($value);
                }
            )->sum();
        
            $each_month_total_hours[] = [
                'month' => Carbon::parse($month)->format('M Y'),
                'hours' => round($total_hours_each_day_in_month, 2)
            ];
        }
        
        $response = [

            'data' => $each_month_total_hours
        ];
        
        return response()->json($response);
    }
    
    /**
     *  Axio Endpoint
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter3Json()
    {
        $model_employee_work_hours = EmployeeWorkHours::query()
            ->with(['employee.company'])
            ->paginate(20);
        
        $response = [
            'pagination' => [
                'total' => $model_employee_work_hours->total(),
                'per_page' => $model_employee_work_hours->perPage(),
                'current_page' => $model_employee_work_hours->currentPage(),
                'last_page' => $model_employee_work_hours->lastPage(),
                'from' => $model_employee_work_hours->firstItem(),
                'to' => $model_employee_work_hours->lastItem()
            ],
            'data' => $model_employee_work_hours
        ];
        
        return response()->json($response);
    }
}
