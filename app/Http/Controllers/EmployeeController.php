<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employees;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{

     public function index()
    {
        $employees = Employees::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $lastEmpNo = Employees::where('employee_code', 'like', 'EMP-%')->orderBy('created_at', 'desc')->first();
        if ($lastEmpNo) {
            $lastNumber = (int) substr($lastEmpNo->employee_code, -4); 
            $newNumber = sprintf("EMP-%04d", $lastNumber + 1); 
        } else {
            $newNumber = "EMP-0001"; 
        }
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'joining_date' => 'nullable|date_format:Y-m-d',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        $employee = new Employees();
        $employee->employee_code = $newNumber;
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->joining_date = $request->joining_date;

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profile_images', 'public');  
            $employee->profile_image = $path;
        }

        $employee->save();

        // return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function ajaxEmployees(Request $request)
    {
        $query = Employees::query();
        if ($request->has('minDate') && $request->has('maxDate')) {
            $query->whereBetween('joining_date', [$request->minDate, $request->maxDate]);
        }

        return DataTables::of($query)
            ->addColumn('full_name', function ($employee) {
                return $employee->first_name . ' ' . $employee->last_name;
            })
            ->addColumn('profile_image', function ($employee) {
                return $employee->profile_image; 
            })
            ->make(true);
    }
}
