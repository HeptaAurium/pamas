<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Payroll;
use App\Models\Staff;
use App\Models\StaffAllowance;
use App\Models\StaffDeduction;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{

    protected $data;

    public function __construct()
    {
        global $data;
        $this->data = &$data;

        $this->data['roles'] = DB::table('roles')->get();
        $this->data['permissions'] = DB::table('permissions')->get();
        $this->data['staff'] = Staff::where('active', 1)->get();
        $this->data['branches'] = Branch::get();
        $this->data['allowances'] = Allowance::get();
        $this->data['settings'] = SystemSetting::where('id', 1)->first();
        $this->data['deductions'] = Deduction::get();
        $this->data['banks'] = Bank::get();
        $this->data['departments'] = Department::get();
        $this->data['staff_allowances'] = DB::table('staff_allowances')->get();
        $this->data['staff_deductions'] = DB::table('staff_deductions')->get();
        $this->data['positions'] = DB::table('staff_positions')->get();
        $this->data['payrolls'] = Payroll::where('month', Date('m'))->where('year', Date('Y'))->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('payroll.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function show(Payroll $payroll)
    {
        //

        return view('payroll.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function edit(Payroll $payroll)
    {
        //
        $this->data['details'] = $payroll;
        $this->data['payroll'] = $payroll;
        $this->data['deds'] = StaffDeduction::where('staff_id', $payroll->id)->get();
        $this->data['alls'] = StaffAllowance::where('staff_id', $payroll->id)->get();
        $this->data['staff'] = $this->data['staff']->where('id', $payroll->staff_id)->first();

        return view('payroll.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payroll $payroll)
    {
        //
    }

    // process the payroll

    public function process(Request $request)
    {
        $staffs = Staff::where('active', 1)->get();
        $success = false;


        foreach ($staffs as $staff) {
            $allowance = StaffAllowance::where('staff_id', $staff->id)->sum('amount');
            $deductions = StaffDeduction::where('staff_id', $staff->id)->sum('amount');
            $basal = $staff->basal;

            $grossPay = $allowance + $basal;
            $taxable_income = $grossPay - $deductions;

            $tax = Self::calc_PAYE($taxable_income);
            $netPay = $grossPay - $tax;

            $payroll = Payroll::where('staff_id', $staff->id)
                ->where('month', Date('m'))
                ->Where('year', Date('Y'))
                ->first();

            if (!empty($payroll)) {
                $payroll->basal = $staff->basal;
                $payroll->gross_pay = $grossPay;
                $payroll->net_pay = $netPay;
                $payroll->total_additions = $allowance;
                $payroll->total_deductions = $deductions;
                $payroll->tax = $tax;
                if ($payroll->save()) $success = true;
            } else {
                $payroll = new Payroll;
                $payroll->staff_id = $staff->id;
                $payroll->basal = $staff->basal;
                $payroll->gross_pay = $grossPay;
                $payroll->net_pay = $netPay;
                $payroll->total_additions = $allowance;
                $payroll->total_deductions = $deductions;
                $payroll->tax = $tax;
                $payroll->bank = $staff->bank;
                $payroll->account_no = $staff->account_no;
                $payroll->month = Date('m');
                $payroll->year = Date('Y');
                if ($payroll->save()) $success = true;
            }
        }

        if ($success) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'fail']);
        }
        // return back();
    }

    static function calc_PAYE($income)
    {
        $relief = SystemSetting::where('id',)->pluck('tax_relief')->first();
        if ($income > 0 && $income < 11180) {
            $tax = 0.1 * $income;
        } elseif ($income > 11180 && $income <= 21715) {
            $tax_1 = 10 / 100 * 11180;
            $taxableBal = $income - 11180;
            $tax_2 = 15 / 100 * $taxableBal;
            $tax = $tax_1 + $tax_2;
        } elseif ($income > 21715  && $income <= 32249) {
            $taxableBal = $income - 21714;
            $tax = (2698 + 0.2 * $taxableBal);
        } elseif ($income > 32249  && $income <= 42728) {
            $taxableBal = $income - 32249;
            $tax = (4804 + 0.25 * $taxableBal);
        } else {
            $taxableBal = $income - 42782;
            $tax = (7438 + 0.3 * $taxableBal);
        }

        return $tax - (int)$relief;
    }
}
