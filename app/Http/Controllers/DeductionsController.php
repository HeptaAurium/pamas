<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Deduction;
use App\Models\Staff;
use App\Models\StaffDeduction;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use projects\name\Log;

class DeductionsController extends Controller
{

    public function __construct()
    {
        global $data;
        $this->data = &$data;

        $this->data['settings'] = SystemSetting::find(1);
        $this->data['tax_groups'] = DB::table('tax_groups')->get();
        $this->data['departments'] = DB::table('departments')->get();
        $this->data['branches'] = DB::table('branches')->get();
        $this->data['position'] = DB::table('staff_positions')->get();
        $this->data['deductions'] = Deduction::get();
        $this->data['staff'] = Staff::get();
        $this->data['staff_deductions'] = DB::table('staff_deductions')->get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('deductions.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('deductions.create', $this->data);
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
            'name' => 'bail|required|unique:deductions,name',
        ]);
        $input = $request->except('_token');


        try {
            $create = Deduction::create($input);
            if (GeneralHelper::add_deduction($create->id)) {
                flash('Deduction added successfully!')->success();
            } else {
                Deduction::where('id', $create->id)->delete();
                flash('We encountered an error while processing your request! Try again later!')->error();
            }
        } catch (\Throwable $th) {
            flash('We encountered an error while processing your request! Try again later!')->error();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function show(Deduction $deduction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function edit(Deduction $deduction)
    {
        //
        $this->data['deduction'] = $deduction;
        return view('deductions.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Deduction $deduction)
    {
        //
        if ($deduction->name != $request->name) {
            $deduction->name = $request->name;
            if ($deduction->save()) {
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
     * @param  \App\Models\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deduction $deduction)
    {
        //
        //
        try {
            StaffDeduction::where('deduction', $deduction->id)->delete();
            if ($deduction->delete()) {
                flash("Deduction " . trans('feedback.discarded_success'))->success();
            }
        } catch (\Throwable $th) {
            \Log::error($th);

            flash(trans('delete_error'))->error();
        }


        return back();
    }

    // Edit staff deductions

    public function staff_deductions($id)
    {
        $deduction = DB::table('staff_deductions')->where('id', $id)->first();

        $this->data['staff'] = Staff::where('id', $deduction->staff_id)->first();
        $this->data['deduction'] = $deduction;

        return view('deductions.staff-deductions', $this->data);
    }
    public function staff_deductions_update(Request $request)
    {
        $id = $request->deduction_id;
        // dd($request);
        try {
            DB::table('staff_deductions')
                ->where('id', $id)
                ->update(['amount' => $request->deduction]);

            flash(trans('feedback.update_success'))->success();
        } catch (\Throwable $th) {
            \Log::error($th);
            flash(trans('feedback.update_error'))->error();
        }

        return back();
    }
}
