<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Bank;
use App\Models\Deduction;
use App\Models\SystemSetting;
use App\Models\Staff;
use App\Models\StaffAllowance;
use App\Models\StaffDeduction;
use Doctrine\DBAL\Query\QueryException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Yajra\Datatables\Facades\Datatables;
use Datatables;
use Illuminate\Support\Facades\Log;
use Sentry\Serializer\Serializer;
use Sentry\ClientBuilderInterface;
use Sentry;

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
        $this->data['allowances'] = Allowance::get();
        $this->data['deductions'] = Deduction::get();
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
        $errors = [];
        $request->validate([
            'staff_unique_id' => 'bail|required|unique:staff,staff_unique_id',
            'national_id' => 'bail|required|unique:staff,national_id',
            'tscno' => 'bail|sometimes|unique:staff,tscno',
        ]);

        $input = $request->except('_token');

        try {
            $staff = Staff::create($input);
            $staff_id = $staff->id;
            // get allowances and deductions if specific allowed
            $setting = $this->data['settings'];


            if ($setting->allowance_grouping == 0) {
                $allowances = Allowance::get();
                foreach ($allowances as $allowance) {
                    $allow_id = $allowance->id;
                    $amount = $request->$allow_id;
                    $amount == "" || empty($amount) ? $amount = 0 : $amount = $amount;

                    DB::table('staff_allowances')->insert([
                        'staff_id' => $staff_id,
                        'allowance' => $allow_id,
                        'amount' =>  $amount,
                        'created_at' => Date('Y-m-d H:i:s'),
                        'updated_at' => Date('Y-m-d H:i:s')
                    ]);
                }
            }

            if ($setting->deductions_grouping == 0) {
                $deductions = Deduction::get();
                foreach ($deductions as $deduction) {
                    $ded_id = $deduction->id;
                    $amount = $request->$ded_id;
                    $amount == "" || empty($amount) ? $amount = 0 : $amount = $amount;
                    DB::table('staff_deductions')->insert([
                        'staff_id' => $staff_id,
                        'deduction' => $amount,
                        'amount' => $request->$ded_id,
                        'created_at' => Date('Y-m-d H:i:s'),
                        'updated_at' => Date('Y-m-d H:i:s'),
                    ]);
                }
            }

            flash('Staff member successfully added!')->success();
        } catch (\Throwable $th) {
            flash('An error was encountered while processing your request! Try again later!')->success();
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
        $this->data['deduction'] = [];
        $this->data['allowance'] = [];

        // $this->data['staff'] = Staff::where('id', $staff->id)->first();
        $this->data['staff'] =  $staff;
        $this->data['staff']['department'] = DB::table('departments')->where('id', $staff->department_id)->pluck('name')->first();
        $this->data['staff']['branch'] = DB::table('branches')->where('id', $staff->branch_id)->pluck('name')->first();
        $this->data['staff']['position'] = DB::table('staff_positions')->where('id', $staff->position)->pluck('name')->first();
        $this->data['staff']['bank'] = DB::table('banks')->where('id', $staff->bank)->pluck('name')->first();
        $this->data['staff']['sec_bank'] = DB::table('banks')->where('id', $staff->secondary_bank)->pluck('name')->first();

        $setting = $this->data['settings'];

        if ($setting->allowance_grouping == 0) {
            $staff_allowances = DB::table('staff_allowances')->where('staff_id', $staff->id)->get();
            foreach ($staff_allowances as $item) {
                $array = [
                    'name' => Allowance::where('id', $item->allowance)->pluck('name')->first(),
                    'amount' => $item->amount,
                    'id'=>$item->id,
                ];

                array_push($this->data['allowance'], $array);
            }
        }
        if ($setting->deduction_grouping == 0) {
            $staff_deductions = DB::table('staff_deductions')->where('staff_id', $staff->id)->get();
            foreach ($staff_deductions as $item) {
                $array = [
                    'name' => Deduction::where('id', $item->deduction)->pluck('name')->first(),
                    'amount' => $item->amount
                ];

                array_push($this->data['deduction'], $array);
            }
        }

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
        return view('staff.edit', $this->data);
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

    // Edit allowances

    public function edit_allowance(Request $request)
    {


        $allowances = Allowance::get();
        foreach ($allowances as $allowance) {
            $all_id = $allowance->id;
            $st_all = StaffAllowance::where('staff_id', $request->staff_id)->where('allowance', $all_id)->first();

            $st_all->amount = $request->$all_id;
            $st_all->save();
        }

        return back();
    }

    public function edit_deduction(Request $request)
    {
        $deductions = Deduction::get();
        foreach ($deductions as $deduction) {
            $all_id = $deduction->id;
            $st_all = StaffDeduction::where('staff_id', $request->staff_id)->where('deduction', $all_id)->first();
            $st_all->amount = $request->$all_id;
            $st_all->save();
        }

        return back();
    }
}
