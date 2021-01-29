@extends('layouts.app')

@section('title', 'Payroll Processing ')

@section('content')
    <div class="container-fluid px-3 py-3 payroll">
        <table class="table table-dark" id="payroll_processed">
            <thead>
                <tr>
                    <th>Staff Name</th>
                    <th>Branch</th>
                    <th>Basic Salary</th>
                    <th>Total Allowances</th>
                    <th>Total Deductions</th>
                    <th>Taxation</th>
                    <th>Net Pay</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payrolls as $item)
                    @php
                    $name = $staff->where('id', $item->staff_id)->pluck('firstname')->first()."
                    ".$staff->where('id',$item->staff_id)->pluck('lastname')->first();
                    $brnch = $staff->where('id', $item->staff_id)->pluck('branch_id')->first();
                    @endphp
                    <tr>
                        <td>{{ $name }}</td>
                        <td>{{ $branches->where('id', $brnch)->pluck('name')->first() }}</td>
                        <td>{{ number_format($item->basal) }}</td>
                        <td>{{ number_format($item->total_additions) }}</td>
                        <td>{{ number_format($item->total_deductions) }}</td>
                        <td>{{ number_format($item->tax) }}</td>
                        <td>{{ number_format($item->net_pay) }}</td>
                        <td>
                            <div class="dropdown">
                                <button id="action" class="btn bg-transparent text-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-expand-arrows-alt    "></i> </button>
                                <div class="dropdown-menu" aria-labelledby="action">
                                    <a class="dropdown-item" href="/payroll/{{$item->id}}/edit">View</a>
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
