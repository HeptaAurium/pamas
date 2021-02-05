@extends('layouts.app')

@section('title', $staff->firstname . ' ' . $staff->lastname . ' Payslip')

@section('content')
    <div class="container px-3 py-3 payroll">
        <div class="row">
            <div class="col-12 float-right pull-right text-right my-3 align-items-center">
                
           
            <form action="/print/payslip" method="POST">
                @csrf
                <input type="hidden" id="ps_staff" name="staff" value="{{ $staff->id }}">
                <input type="hidden" name="month" id="ps_month" value="{{ $payroll->month }}">
                <input type="hidden" name="year" id="ps_year" value="{{ $payroll->year }}">
                <input type="hidden" name="payroll" id="ps_payroll" value="{{ $payroll->id }}">
                <button class="btn btn-flat btn-danger" type="submit" id="printPayslip">
                    <i class="fa fa-file-pdf" aria-hidden="true"></i> Export to PDF
                </button>
            </form>
            
            <div class="col-md-9 col-11 rounded bg-white border mx-auto text-dark shadow p-3" style="min-height:400px;">
                <div class="row px-md-4">

                    <div class="col-6">
                        <h1 class="display col-12 bg-gradient-dark text-white p-3">Payslip</h1>
                        <h3 class="display">{{ $staff->firstname . ' ' . $staff->middlename . ' ' . $staff->lastname }}
                        </h3>

                        <h6 class="font-weight-bold">Branch:
                            <span
                                class="font-weight-lighter">{{ $branches->where('id', $staff->branch_id)->pluck('name')->first() }}</span>
                        </h6>
                        <h6 class="font-weight-bold">Department:
                            <span
                                class="font-weight-lighter">{{ $departments->where('id', $staff->department_id)->pluck('name')->first() }}</span>
                        </h6>
                        <h6 class="font-weight-bold">Position:
                            <span
                                class="font-weight-lighter">{{ $positions->where('id', $staff->position)->pluck('name')->first() }}</span>
                        </h6>
                    </div>
                    <div class="col-6">
                        <div class="text-right">
                            @if (!empty($settings->business_logo) || $settings->business_logo != '')
                                <img src="{{ asset($settings->business_logo) }}" alt="" class="img-fluid w-auto"
                                    style="height:90px;">
                            @endif
                            <h4>{{ $settings->business_name }}</h4>
                            <span>Payslip No: 000{{ $payroll->id . '|' . $payroll->month . $payroll->year }}</span>
                            <p class="font-weight-bold my-3">Date Processed:
                                <span class="font-weight-lighter">
                                    {{ Date('l, jS F Y', strtotime($payroll->updated_at)) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="bg-secondary text-white p-2">Allowances & Additions</h4>
                        <table class="table table-active text-center table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Allowance</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i =1 @endphp
                                @foreach ($alls as $item)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $allowances->where('id', $item->allowance)->pluck('name')->first() }}</td>
                                        <td>{{ $item->amount }}</td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6">
                        <h4 class="bg-secondary text-white p-2">Deductions</h4>
                        <table class="table table-active text-center table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Deduction</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i =1 @endphp
                                @foreach ($deds as $item)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $deductions->where('id', $item->deduction)->pluck('name')->first() }}</td>
                                        <td>{{ $item->amount }}</td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12">
                        <h4 class="bg-secondary text-white p-2">Payments</h4>
                        <table class="table table-active text-center table-striped">
                            <thead>
                                <tr>
                                    <th>Basic Salary</th>
                                    <th>Total Additions</th>
                                    <th>Total Deductions</th>
                                    <th>Tax Relief</th>
                                    <th>Tax <small>(after relief is deducted)</small></th>
                                    {{-- <th>Net Pay</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ number_format($payroll->basal) }}</td>
                                    <td>{{ number_format($payroll->total_additions) }}</td>
                                    <td>{{ number_format($payroll->total_deductions) }}</td>
                                    <td>{{ number_format($settings->tax_relief) }}</td>
                                    <td>{{ number_format($payroll->tax) }}</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 my-2">
                        <h2 class="bg-primary py-3 px-3 text-white">Net Pay &nbsp;&nbsp;&nbsp;&nbsp;
                            <span class="float-right">KSH {{ number_format($payroll->net_pay) }}</span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
