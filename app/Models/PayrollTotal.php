<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PayrollTotal extends Model
{
    use HasFactory;
    protected $table = 'payroll_totals';
    protected $fillable = [
        'salaries', 'allowances', 'deductions', 'tax', 'payout', 'month', 'year'
    ];

    // Compute totals
    static function compute_totals($totals)
    {
        $total = DB::table('payroll_totals')
            ->where('month', Date('m'))
            ->where('year', Date('Y'))
            ->first();
        $data = [
            'salaries' => $totals['salary'],
            'allowances' => $totals['allowances'],
            'deductions' => $totals['deductions'],
            'tax' => $totals['tax'],
            'payout' => $totals['payout'],
            'month' => Date('m'),
            'year' => Date('Y'),
            'updated_at' => Date('Y-m-d H:i:s'),
            'created_at' => Date('Y-m-d H:i:s'),
        ];

        if (empty($total)) {
            DB::table('payroll_totals')->insert($data);
        } else {
            DB::table('payroll_totals')->update($data);
        }
    }

    static function compute_payroll()
    {
        $staffs = Staff::where('active', 1)->get();
        $success = false;
        $totals = [];
        $totals['salary'] = 0;
        $totals['allowances'] = 0;
        $totals['deductions'] = 0;
        $totals['tax'] = 0;
        $totals['payout'] = 0;


        foreach ($staffs as $staff) {
            $allowance = StaffAllowance::where('staff_id', $staff->id)->sum('amount');
            $deductions = StaffDeduction::where('staff_id', $staff->id)->sum('amount');
            $settings = SystemSetting::find(1);

            $basal = $staff->basal;
            if (empty($allowance)) $allowance = 0;
            if (empty($deduction)) $deduction = 0;
            $grossPay = $allowance + $basal;
            $taxable_income = $grossPay - $deductions;

            $totals['salary'] += $basal;
            $totals['allowances'] += $allowance;
            $totals['deductions'] += $deductions;

            if ($settings->include_income_tax == 1) {
                $tax = Self::compute_PAYE($taxable_income);
            } else {
                $tax = 0;
            }

            $totals['tax'] += $tax;

            $netPay = $grossPay - ($tax + $deductions);

            $totals['payout']  += $netPay;

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

        Self::compute_totals($totals);
        return $success;
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

    static function compute_PAYE($income)
    {
        $configs = DB::table('paye_configs')->where('id', 1)->first();
        $rates  = DB::table('paye_rates')->get();
        $rate_ids  = [];

        foreach ($rates as $rate) {
            array_push($rate_ids, $rate->id);
        }

        if ($income <= $configs->minimum_taxable_income) {
            return 0; //minimum taxable income not met
        }

        $step = $configs->step;
        $remaining = $income;

        $bracket  =   DB::table('paye_rates')
            ->where('min', '<', $income)
            ->where('max', '>', $income)
            ->first();

        $first_bracket = $rates[0];
        $n = array_search($bracket->id, $rate_ids);
        $tax = 0;

        // tax all brackets from $n=0 to $n-1

        for ($i = 0; $i < $n; $i++) {
            if ($i == 0) {  // first bracket
                $tax += $first_bracket->rate / 100 * $first_bracket->max;
                $remaining -= $first_bracket->max;
            } else {
                $tax += $rates[$i]->rate / 100 * $step;
                $remaining -= $step;
            }
        }

        // tax the current bracket
        $tax += $bracket->rate / 100 * $remaining;

        $relief = isset($configs->tax_relief) ? $configs->tax_relief : 0;
        $tax -= $relief;
        return $tax < 0 ? 0 : $tax;
    }
}
