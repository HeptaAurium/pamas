<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Department;
use App\Models\Staff;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
{

    protected $data;

    public function __construct()
    {
        global $data;
        $hasPrimaryBank = true;

        $this->data = &$data;
        $this->data['settings'] = SystemSetting::find(1);
        $this->data['staff'] = Staff::get();
        $this->data['departments'] = DB::table('departments')->get();
        $this->data['branches'] = DB::table('branches')->get();
        $this->data['position'] = DB::table('staff_positions')->get();
        $this->data['primary_bank'] = Bank::where('is_primary', 1)->first();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return  view('departments.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('departments.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'bail|required|unique:departments,name',
        ]);
        $input = $request->except('_token');


        try {
            $create = new Department;
            $create->create($input);

            flash('Department added successfully!')->success();
        } catch (\Throwable $th) {
            flash('We encountered an error while processing your request! Try again later!')->error();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
        $this->data['depart'] = $department;
        return view('departments.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //
        if ($department->name != $request->name) {
            $department->name = $request->name;
            if ($department->save()) {
                flash(trans('feedback.update_success'))->success();
            } else {
                flash(trans('feedback.update_error'))->error();
            }
        } else {
            flash("No changes made!")->warning();
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
        if ($department->delete()) {
            flash("Department discarded successfully!")->success();
        } else {
            flash('We encountered an error while processing your request! Try again later!')->error();
        }

        return back();
    }
}
