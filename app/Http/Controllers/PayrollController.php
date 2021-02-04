<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Allowance;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Payroll;
use App\Models\PayrollTotal;
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
        $this->data['years'] = [];
        $years = PayrollTotal::get();
        foreach ($years as $year) {
            $yyr = $year->year;

            if (!in_array($yyr, $this->data['years'])) {
                array_push($this->data['years'], $yyr);
            }
        }
        $this->data['payrolls'] = Payroll::where('month', Date('m'))->where('year', Date('Y'))->get();

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
        $success = PayrollTotal::compute_payroll();

        if ($success) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'fail']);
        }
        // return back();
    }

    public function filter(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        

        $payrolls = Payroll::where('month', $month)
            ->where('year', $year)
            ->get();
            // if (strlen($month) == 1) $month = '0' . $month;
            // $month = Date('m', strtotime($month));

        if (count($payrolls) == 0) {
            echo "<tr><td colspan='8' class='text-center text-muted display-4'>No data found!</td></tr>";
        } else {
            foreach ($payrolls as $item) :
                $staff = Staff::find($item->staff_id);
                $name = $staff->firstname . " " . $staff->lastname;
                echo "<tr>
            <td>" . $name . "</td>
            <td>" . Branch::where('id', $staff->branch_id)->pluck('name')->first() . "</td>
            <td>" . number_format(strlen($month)) . "</td>
            <td>" . number_format($item->total_additions) . "</td>
            <td>" . number_format($item->total_deductions) . "</td>
            <td>" . number_format($item->tax) . "</td>
            <td>" . number_format($item->net_pay) . "</td>
            <td> " . Date('jS M Y, h:i A', strtotime($item->updated_at)) . "</td>
            <td>
                <div class='dropdown'>
                    <button id='action' class='btn bg-transparent text-white dropdown-toggle'
                        data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> <i
                            class='fas fa-expand-arrows-alt    '></i> </button>
                    <div class='dropdown-menu' aria-labelledby='action'>
                        <a class='dropdown-item' href='/payroll/'. $item->id .'/edit'>View</a>
                        <a class='dropdown-item' href='#'>View Payslip</a>
                    </div>
                </div>
            </td>
        </tr>";
            endforeach;
        }
    }
}
