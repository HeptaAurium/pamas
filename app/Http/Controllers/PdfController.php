<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Payroll;
use App\Models\Position;
use App\Models\Staff;
use App\Models\StaffAllowance;
use App\Models\StaffDeduction;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
    //
    protected $data;

    public function __construct()
    {
        global $data;
        $this->data = &$data;

        $this->data['staff'] = Staff::get();
        $this->data['branches'] = Branch::get();
        $this->data['banks'] = Bank::get();
        $this->data['staff_allowances'] = StaffAllowance::get();
        $this->data['staff_deductions'] = StaffDeduction::get();
        $this->data['allowances'] = Allowance::get();
        $this->data['deductions'] = Deduction::get();
        $this->data['departments'] = Department::get();
        $this->data['branches'] = Branch::get();
        $this->data['positions'] = Position::get();
        $this->data['settings'] = SystemSetting::find(1);
    }

    public function index(Request $request)
    {
        $this->data['payrolls'] = Payroll::where('month', $request->month)->where('year', $request->year)->get();
        $this->data['request'] = $request;
        $record = $this->data['payrolls'][0]->updated_at;
        $this->data['date'] = Date('F Y', strtotime($record));
        $pdf = PDF::loadView('payroll.prints.standing_orders', $this->data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('payroll.pdf', array('Attachment' => 0));
    }
    public function payslip(Request $request)
    {
        $payroll = Payroll::find($request->payroll);
        // dd($request->month);
        $this->data['details'] = $payroll;
        $this->data['payroll'] = $payroll;
        $this->data['deds'] = StaffDeduction::where('staff_id', $payroll->id)->get();
        $this->data['alls'] = StaffAllowance::where('staff_id', $payroll->id)->get();
        $this->data['staff'] = $this->data['staff']->where('id', $payroll->staff_id)->first();

        $pdf = PDF::loadView('payroll.prints.payslip', $this->data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('payroll.pdf', array('Attachment' => 0));

        // return view('payroll.prints.payslip', $this->data);
    }
}
