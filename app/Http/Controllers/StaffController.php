<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\SystemSetting;
use App\Models\Staff;
use Doctrine\DBAL\Query\QueryException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Yajra\Datatables\Facades\Datatables;
use Datatables;


class StaffController extends Controller
{
    protected $data;

    public function __construct()
    {
        global $data;
        $hasPrimaryBank = true;
        $this->data = &$data;
        $this->data['settings'] = SystemSetting::find(1);
        $this->data['tax_groups'] = DB::table('tax_groups')->get();
        $this->data['departments'] = DB::table('departments')->get();
        $this->data['branches'] = DB::table('branches')->get();
        $this->data['position'] = DB::table('staff_positions')->get();
        $this->data['banks'] = Bank::get();
        $this->data['primary_bank'] = Bank::where('is_primary', 1)->first();
        if ($this->data['settings']->has_primary_bank != 1) {
            $hasPrimaryBank = false;
        }
        $this->data['globals']['hasPrimaryBank'] = $hasPrimaryBank;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->data['staff'] = [];
        $staff = Staff::where('active', 1)->get();

        foreach ($staff as $st) {
            $array = [
                'id' => $st->id,
                'name' => $st->firstname . " " . $st->middlename . " " . $st->lastname,
                'department' => DB::table('departments')->where('id', $st->department_id)->pluck('name')->first(),
                'branch' => DB::table('branches')->where('id', $st->branch_id)->pluck('name')->first(),
                'phone' => $st->phone,
                'email' => $st->email,
                'position' => DB::table('staff_positions')->where('id', $st->position)->pluck('name')->first(),
            ];

            array_push($this->data['staff'], $array);
        }

        // return Datatables::of($this->data['staff'])->make(true);

        return view('staff.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


        return view('staff.create', $this->data);
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
            'staff_unique_id' => 'bail|required|unique:staff,staff_unique_id',
            'national_id' => 'bail|required|unique:staff,national_id',
            'tscno' => 'bail|required|unique:staff,tscno',
        ]);

        $input = $request->except('_token');
        $staff = new Staff;
        try {
            $staff->create($input);
            flash('Staff member successfully added!')->success();
        } catch (QueryException $e) {
            flash('We encountered an error while processing your request! Try again later!')->error();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
        $this->data['staff'] = [];
        // $this->data['staff'] = Staff::where('id', $staff->id)->first();
        $this->data['staff'] =  $staff;
        $this->data['staff']['department'] = DB::table('departments')->where('id', $staff->department_id)->pluck('name')->first();
        $this->data['staff']['branch'] = DB::table('branches')->where('id', $staff->branch_id)->pluck('name')->first();
        $this->data['staff']['position'] = DB::table('staff_positions')->where('id', $staff->position)->pluck('name')->first();
        $this->data['staff']['bank'] = DB::table('banks')->where('id', $staff->bank)->pluck('name')->first();
        $this->data['staff']['sec_bank'] = DB::table('banks')->where('id', $staff->secondary_bank)->pluck('name')->first();
        // dd($this->data['staff']->firstname);
        return view('staff.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        //

        $staff->active = 0;
        $staff->deleted_at = Date('Y-m-d H:i:s');
        $staff->save();
        flash('Staff Member deactivated')->success();


        return back();
    }
}
