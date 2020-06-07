<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Excel;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;
use App\Country;
use App\Department;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        date_default_timezone_set('africa/nairobi');
        $format = 'Y/m/d';
        $now = date($format);
        $to = date($format, strtotime("+30 days"));
        $constraints = [
            'from' => $now,
            'to' => $to
        ];
        $countries = Country::all();
        $departments = Department::all();

        $employees = $this->getHiredEmployees($constraints);
        return view('system-mgmt/report/index', ['employees' => $employees, 'searchingVals' => $constraints,
        'countries' => $countries, 'departments' => $departments]);
    }

    public function exportExcel(Request $request) {
        $this->prepareExportingData($request)->export('xlsx');
        redirect()->intended('system-management/report');
    }

    public function exportPDF(Request $request) {
         $constraints = [
            'from' => $request['from'],
            'to' => $request['to']
        ];
        $employees = $this->getExportingData($constraints);
        $pdf = PDF::loadView('system-mgmt/report/pdf', ['employees' => $employees, 'searchingVals' => $constraints]);
        return $pdf->download('report_from_'. $request['from'].'_to_'.$request['to'].'pdf');
        // return view('system-mgmt/report/pdf', ['employees' => $employees, 'searchingVals' => $constraints]);
    }
    
    private function prepareExportingData($request) {
        $author = Auth::user()->username;
        $employees = $this->getExportingData(['from'=> $request['from'], 'to' => $request['to']]);
        return Excel::create('report_from_'. $request['from'].'_to_'.$request['to'], function($excel) use($employees, $request, $author) {

        // Set the title
        $excel->setTitle('List of hired employees from '. $request['from'].' to '. $request['to']);

        // Chain the setters
        $excel->setCreator($author)
            ->setCompany('Employees');

        // Call them separately
        $excel->setDescription('The list of hired employees');

        $excel->sheet('Hired_Employees', function($sheet) use($employees) {

        $sheet->fromArray($employees);
            });
        });
    }

    public function search(Request $request) {
        //if country is specified include country

        $constraints = [
            'from' => $request['from'],
            'to' => $request['to']
        ];
        $countries = Country::all();
        $departments = Department::all();
        $employees = $this->getHiredEmployees($constraints);
        return view('system-mgmt/report/index', ['employees' => $employees, 'searchingVals' => $constraints,
        'countries' => $countries, 'departments' => $departments]);
    }

    public function searchCountry(Request $request){
        $constraints = [
            'from' => $request['from'],
            'to' => $request['to'],
            "country_id" => $request['country_id']
        ];

        $countries = Country::all();
        $departments = Department::all();

        $employees = Employee::where('country_id', $constraints['country_id'])
                                ->where('date_hired', '>=', $constraints['from'])
                                ->where('date_hired', '<=', $constraints['to'])
                                ->get();
        return view('system-mgmt/report/index', ['employees' => $employees, 'searchingVals' => $constraints
        ,'countries' => $countries, 'departments' => $departments]);
    }

        public function searchDepartment(Request $request){
        $constraints = [
            'from' => $request['from'],
            'to' => $request['to'],
            "department_id" => $request['department_id']
        ];

        $countries = Country::all();
        $departments = Department::all();

        $employees = Employee::where('department_id', $constraints['department_id'])
                                ->where('date_hired', '>=', $constraints['from'])
                                ->where('date_hired', '<=', $constraints['to'])
                                ->get();
        return view('system-mgmt/report/index', ['employees' => $employees, 'searchingVals' => $constraints
        ,'countries' => $countries, 'departments' => $departments]);
    }



    private function getHiredEmployees($constraints) {
        $employees = Employee::where('date_hired', '>=', $constraints['from'])
                        ->where('date_hired', '<=', $constraints['to'])
                        ->get();
        return $employees;
    }

    private function getExportingData($constraints) {
        $department_id = "";
        try{
            $department_id = $constraints['department_id'];
        }catch(Exception $ex){
            $department_id = "";
        }

        $country_id = "";
        try{
            $country_id = $constraints['country_id'];
        }catch(Exception $ex){
            $country_id = "";
        }

        return DB::table('employees')
        // ->leftJoin('city', 'employees.city_id', '=', 'city.id')
        ->leftJoin('department', 'employees.department_id', '=', 'department.id')
        // ->leftJoin('state', 'employees.state_id', '=', 'state.id')
        ->leftJoin('country', 'employees.country_id', '=', 'country.id')
        ->leftJoin('division', 'employees.division_id', '=', 'division.id')
        ->select('employees.firstname', 'employees.middlename', 'employees.lastname', 
        'employees.age','employees.birthdate', 'employees.address', 'employees.zip',
        'employees.nhif', 'employees.nssf','employees.salary','employees.date_hired',
        'department.name as department_name', 'division.name as division_name')
        ->where('date_hired', '>=', $constraints['from'])
        ->where('date_hired', '<=', $constraints['to'])
        ->where('department_id', $department_id)
        ->where('country_id', $country_id)
        ->get()
        ->map(function ($item, $key) {
        return (array) $item;
        })
        ->all();
    }
}
