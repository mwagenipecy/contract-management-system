<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){

        return view('pages.employee.index');

    }


    public function show($employee){


        $employee=Employee::find($employee);
        return view('pages.employee.show',['employee'=>$employee]);
    }
}
