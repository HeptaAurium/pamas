@extends('layouts.app')

@section('title', 'Payroll Processing ')

@section('content')
    <div class="container-fluid px-3 py-3 payroll">
        <div class="processing flex-center flex-column" id="processing_mails">
            <div class="spinner-border text-primary" role="status">

            </div>
            <h3 class="display mt-4">Processing...</h3>
        </div>
        <div class="d-flex flex-row">
            <div class="col-lg-6 row flex-row text-white mt-2 align-items-center">
                <div class="form-group col-6">
                    <select id="filter_month" class="custom-select filter" name="month">
                        @php
                            $start = Date('01-01-2000');
                            
                        @endphp
                        @for ($i = 0; $i < 12; $i++)
                            @php $month = Date('m', strtotime('+' . $i . ' month', strtotime($start))); @endphp
                            <option value="{{ $month }}" @if (Date('m') == $month) selected @endif>
                                {{ Date('F', strtotime('+' . $i . ' month', strtotime($start))) }}</option>
                        @endfor


                    </select>
                </div>
                <div class="form-group col-6">
                    <select id="filter_year" class="custom-select filter" name="year">
                        @foreach ($years as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="col-md-6 float-right pull-right text-right mt-2 align-items-center">
                <button class="btn btn-flat btn-danger">
                    <i class="fa fa-file-pdf" aria-hidden="true"></i> Export to PDF
                </button>
                <button class="btn btn-flat btn-info btn-send-mails">
                   <i class="fas fa-mail-bulk"></i> Mail Payslips
                </button>
            </div>
        </div>
        <table class="table table-dark table-sm table-condensed" id="payroll_processed">
            <thead>
                <tr>
                    <th>Staff Name</th>
                    <th>Branch</th>
                    <th>Basic Salary</th>
                    <th>Total Allowances</th>
                    <th>Total Deductions</th>
                    <th>Taxation</th>
                    <th>Net Pay</th>
                    <th>Date Processed</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="payroll_data">
                @foreach ($payrolls as $item)
                    @php
                        $name =
                            $staff
                                ->where('id', $item->staff_id)
                                ->pluck('firstname')
                                ->first() .
                            "
                                                                                                                                                                                                                                                                                                                                            " .
                            $staff
                                ->where('id', $item->staff_id)
                                ->pluck('lastname')
                                ->first();
                        $brnch = $staff
                            ->where('id', $item->staff_id)
                            ->pluck('branch_id')
                            ->first();
                    @endphp
                    <tr>
                        <td>{{ $name }}</td>
                        <td>{{ $branches->where('id', $brnch)->pluck('name')->first() }}</td>
                        <td>{{ number_format($item->basal) }}</td>
                        <td>{{ number_format($item->total_additions) }}</td>
                        <td>{{ number_format($item->total_deductions) }}</td>
                        <td>{{ number_format($item->tax) }}</td>
                        <td>{{ number_format($item->net_pay) }}</td>
                        <td>{{ Date('H:i - jS M Y ', strtotime($item->updated_at)) }}</td>
                        <td>
                            <div class="dropdown">
                                <button id="action" class="btn bg-transparent text-white dropdown-toggle"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                        class="fas fa-expand-arrows-alt    "></i> </button>
                                <div class="dropdown-menu" aria-labelledby="action">
                                    <a class="dropdown-item" href="/payroll/{{ $item->id }}/edit">View</a>
                                    <a class="dropdown-item" href="#">View Payslip</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
