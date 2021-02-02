<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Allowance;
use App\Models\Staff;
use App\Models\StaffAllowance;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use projects\name\Log;

class AllowancesController extends Controller
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
        $this->data['allowances'] = Allowance::get();
        $this->data['staff'] = Staff::get();
        $this->data['staff_allowances'] = DB::table('staff_allowances')->get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('allowances.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('allowances.create', $this->data);
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
            'name' => 'bail|required|unique:allowances,name',
        ]);
        $input = $request->except('_token');


        try {
            $create = Allowance::create($input);
            if (GeneralHelper::add_allowance($create->id)) {
                flash('Allowance added successfully!')->success();
            } else {
                Allowance::where('id', $create->id)->delete();
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
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function show(Allowance $allowance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function edit(Allowance $allowance)
    {
        //
        $this->data['allowance'] = $allowance;
        return view('allowances.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Allowance $allowance)
    {
        //
        if ($allowance->name != $request->name) {
            $allowance->name = $request->name;
            if ($allowance->save()) {
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
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Allowance $allowance)
    {
        //
        //
        try {
            StaffAllowance::where('allowance', $allowance->id)->delete();
            if ($allowance->delete()) {
                flash("Allowance " . trans('feedback.discarded_success'))->success();
            }
        } catch (\Throwable $th) {
            \Log::error($th);

            flash(trans('delete_error'))->error();
        }


        return back();
    }

    // Edit staff allowances

    public function staff_allowances($id)
    {
        $allowance = DB::table('staff_allowances')->where('id', $id)->first();

        $this->data['staff'] = Staff::where('id', $allowance->staff_id)->first();
        $this->data['allowance'] = $allowance;

        return view('allowances.staff-allowances', $this->data);
    }
    public function staff_allowances_update(Request $request)
    {
        $id = $request->allowance_id;
        // dd($request);
        try {
            DB::table('staff_allowances')
                ->where('id', $id)
                ->update(['amount' => $request->allowance]);

            flash(trans('feedback.update_success'))->success();
        } catch (\Throwable $th) {
            \Log::error($th);
            flash(trans('feedback.update_error'))->error();
        }

        return back();
    }
}
