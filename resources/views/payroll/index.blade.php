@extends('layouts.app')

@section('title', 'Payroll Processing ')

@section('content')
    <div class="container px-3 py-3">
        <div class="panel">
            <div class="process">
                <button class="btn btn-success btn-lg position-fixed" style="z-index:999;">Process Payroll</button>
            </div>
            <table class="table table-dark table-striped table-bordered table-hover table-responsive-md shadow"
                id="tbl_payroll">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Basic Salary</th>
                        <th>Bank</th>
                        <th>Account No</th>
                        <th>Total Allowances</th>
                        {{-- <th></th> --}}
                        <th>Total Deductions</th>
                        {{-- <th></th> --}}

                    </tr>
                </thead>
                <tbody>
                    @foreach ($staff as $item)
                        <tr>
                            @php $name = $item->firstname . ' ' . $item->lastname @endphp
                            <td>{{ $name }}</td>
                            <td>{{ $branches->where('id', $item->branch_id)->pluck('name')->first() }}</td>
                            <td>{{ number_format($item->basal) }}</td>
                            <td>{{ $banks->where('id', $item->bank)->pluck('name')->first() }}</td>
                            <td>{{ $item->account_no }}</td>
                            <td>{{ number_format($staff_allowances->where('staff_id', $item->id)->sum('amount')) }}
                                <button class="btn text-white float-right" data-toggle="modal"
                                data-target="#editAllowanceModal{{ $item->id }}">
                                <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                            </button>
                                @include('modals.edit-allowances')
                            </td>
                            <td>{{ number_format($staff_deductions->where('staff_id', $item->id)->sum('amount')) }}
                                <button class="btn text-white float-right" data-toggle="modal"
                                    data-target="#editDeductionModal{{ $item->id }}">
                                    <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                </button>
                                @include('modals.edit-deductions')
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Import modal --}}
    

@endsection
