<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use App\EmployeeWorkHours;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use function collect;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @var string
     */
    public static $API_URL = "https://nuvalo.merrant.ee/workhours?start=2018-01-01&end=2018-01-31";
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
    /**
     * @return mixed
     */
    public function curlResponse()
    {
        $curl_init = curl_init();
        curl_setopt($curl_init, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_init, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_init, CURLOPT_USERAGENT, 'rohit');
        curl_setopt($curl_init, CURLOPT_URL, self::$API_URL);
        $curl_response = curl_exec($curl_init);
        curl_close($curl_init);
        
        return $curl_response;
    }
    
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDataFromApi()
    {
        /**
         * API Decode Response
         */
        $response = json_decode($this->curlResponse(), true);
        
        //Collect Filter
        $data_collect_employee = $this->collectFilter($response, 'employee');
        //Store Collection
        $this->storeEmployee($data_collect_employee);
        
        //Collect Filter
        $data_collect_employee_work_hours = $this->collectFilter($response, 'employee_work_hours');
        //Store Collection
        $this->storeEmployeeWorkHours($data_collect_employee_work_hours);
        
        //Collect Filter
        $data_collect_company = $this->collectFilter($response, 'company');
        //Store Collection
        $this->storeCompany($data_collect_company);
    
        /**
         * After Save
         * Redirect To Home
         */
        return redirect()->home();
    }
    
    /**
     * @param $response
     * @param bool $type
     * @return mixed
     */
    public function collectFilter($response, $type = false)
    {
        /**
         * Collect API Response
         * Callback returns selected type collection
         * Filter out duplicates
         * Return Instance
         */
        return collect($response)->map(function ($data) use ($type) {
            $array_response = null;
            if ($type == "employee_work_hours") {
                $array_response = Arr::except($data, 'employee');
            } elseif ($type == "employee") {
                $array_response = Arr::except($data['employee'], 'company');
            } elseif ($type == "company") {
                $array_response = $data['employee']['company'];
            }
            
            return $array_response;
        })->unique()->values();
    }
    
    /**
     * @param $data_collect_employee
     */
    public function storeEmployee($data_collect_employee)
    {
        try {
            foreach ($data_collect_employee as $employee) {
                Employee::query()->updateOrCreate($employee);
            }
        } catch (ModelNotFoundException $exception) {
            die('api save failed employee');
        }
    }
    
    /**
     * @param $data_collect_employee_work_hours
     */
    public function storeEmployeeWorkHours($data_collect_employee_work_hours)
    {
        try {
            foreach ($data_collect_employee_work_hours as $employee_work_hours) {
                EmployeeWorkHours::query()->updateOrCreate($employee_work_hours);
            }
        } catch (ModelNotFoundException $exception) {
            die('api save failed employee work hours');
        }
    }
    
    /**
     * @param $data_collect_company
     */
    public function storeCompany($data_collect_company)
    {
        try {
            foreach ($data_collect_company as $company) {
                Company::query()->updateOrCreate($company);
            }
            
        } catch (ModelNotFoundException $exception) {
            die('api save failed company');
        }
    }
}
