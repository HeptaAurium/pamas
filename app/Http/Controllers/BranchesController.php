<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Staff;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchesController extends Controller
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
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('branches.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('branches.create', $this->data);
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
            'name' => 'bail|required|unique:branches,name',
        ]);
        $input = $request->except('_token');


        try {
            $create = new Branch;
            $create->create($input);

            flash('Branch added successfully!')->success();
        } catch (\Throwable $th) {
            flash('We encountered an error while processing your request! Try again later!')->error();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        //
        $this->data['bran'] = $branch;
        return view('branches.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        //
        if ($branch->name != $request->name) {
            $branch->name = $request->name;
            if ($branch->save()) {
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
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        //
        if ($branch->delete()) {
            flash("Branch " . trans('feedback.discarded_success'))->success();
        } else {
            flash(trans('delete_error'))->error();
        }

        return back();
    }
}
