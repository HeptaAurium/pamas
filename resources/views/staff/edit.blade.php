@extends('layouts.app')
@php $staff_name = $staff->firstname . ' ' . $staff->lastname @endphp
@section('title', $staff_name)

@section('content')
    <div class="staff-profiles px-3 py-3">
        <div class="container">
            <form action="">
                <div class="main-body">
                    <div class="row gutters-sm">
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <img src="{{ asset($staff->photo) }}"
                                            alt="{{ $staff->firstname . __(' ') . $staff->lastname }}"
                                            class="rounded-circle profile-pic" width="150">
                                        <div class="mt-3">
                                            <h4 class="text-dark">{{ $staff->firstname . ' ' . $staff->lastname }}</h4>
                                            <p class="text-secondary mb-1">{{ $staff['position'] }}</p>
                                            <p class="text-muted font-size-sm">
                                                {{ $staff['department'] . ', ' . $staff['branch'] }}
                                            </p>
                                            <a href="/staff/{{ $staff->id }}/edit" class="btn btn-primary btn-block">
                                                <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                Edit Details
                                            </a>
                                            {{-- <button class="btn btn-danger my-2">
                                            <i class="fas fa-file-pdf"></i>
                                            Print Profile Card
                                        </button> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h6 class="mb-0">Full Name</h6>
                                        </div>
                                        <div class="col-md-9 text-secondary">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" class="editable form-control"
                                                        value="{{ $staff->firstname }}" name="firstname"
                                                        placeholder="First Name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="editable form-control"
                                                        value="{{ $staff->middlename }}" name="middlename"
                                                        placeholder="Middle Name">
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" class="editable form-control"
                                                        value="{{ $staff->lastname }}" name="lastname"
                                                        placeholder="Last Name" required>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h6 class="mb-0">Staff ID</h6>
                                        </div>
                                        <div class="col-md-9 text-secondary">
                                            <input type="text" class="form-control editable"
                                                value="{{ $staff->staff_unique_id }}" name="staff_unique_id"
                                                placeholder="Staff/Employee No" required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-md-9 text-secondary">
                                            <input type="text" class="form-control editable" value="{{ $staff->email }}"
                                                placeholder="Email Address" name="email" required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h6 class="mb-0">Phone</h6>
                                        </div>
                                        <div class="col-md-9 text-secondary">
                                            <input type="text" class="form-control editable" value="{{ $staff->phone }}"
                                                placeholder="Phone number" name="phone" required>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <h6 class="mb-0">Home Address</h6>
                                        </div>
                                        <div class="col-md-9 text-secondary">
                                            <div class="row">
                                                <div class="col-4">
                                                    <input type="text" class="form-control editable"
                                                        value="{{ $staff->location }}" name="location">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control editable"
                                                        value="{{ $staff->estate }}" name="estate">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control editable"
                                                        value="{{ $staff->houseno }}" name="houseno">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h6 class="mb-0">Department</h6>
                                        </div>
                                        <div class="col-md-9 text-secondary">
                                            @php
                                                $departName = $departments
                                                    ->where('id', $staff->department_id)
                                                    ->pluck('name')
                                                    ->first();
                                            @endphp
                                            <div class="depart-readonly @if (empty($departName) ||
                                                $departName=='' ) hide @endif">
                                                    <input type=" text" class="form-control" value="{{ $departName }}"

                                                readonly>
                                                <small class="form-text text-muted">Click to change</small>
                                            </div>
                                            <div class="depart-select hide">
                                                <select id="my-select" class="custom-select" name="">
                                                   @foreach ($departments as $item)
                                                       <option value="{{$item->id}}" @if($item->id==$staff->department_id) selected @endif>{{$item->name}}</option>
                                                   @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <hr> 
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h6 class="mb-0">Branch</h6>
                                        </div>
                                        <div class="col-md-9 text-secondary">
                                            @php
                                                $branchName = $branches
                                                    ->where('id', $staff->branch_id)
                                                    ->pluck('name')
                                                    ->first();
                                            @endphp
                                            <div class="branch-readonly @if (empty($branchName) ||
                                                $branchName=='' ) hide @endif">
                                                    <input type=" text" class="form-control" value="{{ $branchName }}"

                                                readonly>
                                                <small class="form-text text-muted">Click to change</small>
                                            </div>
                                            <div class="branch-select hide">
                                                <select id="my-select" class="custom-select" name="">
                                                   @foreach ($branches as $item)
                                                       <option value="{{$item->id}}" @if($item->id==$staff->branch_id) selected @endif>{{$item->name}}</option>
                                                   @endforeach
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>

                                </div>
                            </div>
                            <div class="row gutters-sm">
                                <div class="col-sm-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="bg-secondary text-white p-2 mb-3">
                                                Payment Info
                                            </h6>
                                            <small>Basic Salary</small>
                                            <div class="mb-3">
                                                {{ number_format($staff->basal) }}
                                            </div>

                                            <h6 class="bg-secondary text-white p-2 mb-3"><i
                                                    class="fas fa-money-bill    "></i>
                                                &nbsp; Banking Info</h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <small>Bank</small>
                                                    <div class="mb-3">
                                                        {{ $staff['bank'] }}
                                                    </div>
                                                    <small>Account No</small>
                                                    <div class="mb-3">
                                                        {{ $staff->account_no }}
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    @if (!empty($staff['sec_bank']))
                                                        <small>Secondary Bank</small>
                                                        <div class="mb-3">
                                                            {{ $staff['sec_bank'] }}
                                                        </div>
                                                        <small>Account No</small>
                                                        <div class="mb-3">
                                                            {{ $staff->secondary_acc }}
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">

                                            <div class="pb-2">
                                                <h6 class="bg-secondary text-white p-2 mb-4 align-items-center">
                                                    Allowances
                                                    @if ($settings->allowance_grouping == 0)

                                                    @endif
                                                </h6>
                                                <div class="row">
                                                    @foreach ($allowance as $item)
                                                        <div class="col-6">
                                                            <label class="bg-light w-100 px-1">
                                                                <small>
                                                                    {{ $item['name'] }} <a
                                                                        href="/allowance/edit/{{ $item['id'] }}"
                                                                        class="btn float-right p-0"> <i
                                                                            class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                                    </a>
                                                                </small>
                                                            </label>
                                                            <div>
                                                                KSH {{ number_format($item['amount']) }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="pb-2">
                                                <h6 class="bg-secondary text-white p-2 mb-2">Deductions
                                                </h6>
                                                <div class="row">
                                                    @foreach ($deduction as $ded)
                                                        <div class="col-6">
                                                            <label class="bg-light w-100 px-1">
                                                                <small>
                                                                    {{ $ded['name'] }}<a
                                                                        href="/deduction/edit/{{ $item['id'] }}"
                                                                        class="btn float-right p-0"> <i
                                                                            class="fa fa-pencil-alt" aria-hidden="true"></i>
                                                                    </a>
                                                                </small>
                                                            </label>
                                                            <div>
                                                                KSH {{ number_format($ded['amount']) }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
