@extends('layouts.app')
@php $staff_name = $staff->firstname . ' ' . $staff->lastname @endphp
@section('title', $staff_name)

@section('content')
    <div class="staff-profiles px-3 py-3">
        <div class="container">
            <form action="/staff/{{ $staff->id }}" method="POST">
                @csrf
                @method('put')
                <div class="main-body">
                    <div class="row gutters-sm">
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex flex-column align-items-center text-center">
                                        <div class="position-relative">
                                            @if (empty($staff->photo) || $staff->photo == '')
                                                <div class="rounded-circle flex-center bg-secondary my-2 p-2 shadow edit-pic"
                                                    style="width:150px;height:150px;">
                                                    <h1 class="display-4 text-light"
                                                        style="font-family: 'Yusei Magic', sans-serif;">
                                                        <span>{{ $staff->firstname[0] }}</span><span>{{ $staff->lastname[0] }}</span>
                                                    </h1>
                                                </div>
                                            @else
                                                <img src="{{ asset($staff->photo) }}"
                                                    class="rounded-circle profile-pic edit-pic" width="150">
                                            @endif
                                            <div class="prof-img-div flex-center">
                                                <button class="btn bg-transparent" data-toggle="modal"
                                                    data-target="#editStaffProfilePic" type="button">
                                                    <i class="fa fa-camera-retro" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <h4 class="text-dark">{{ $staff->firstname . ' ' . $staff->lastname }}</h4>
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <div class="row text-left">
                                                        <div class="col-md-12">
                                                            <h6 class="mb-0">Department</h6>
                                                        </div>
                                                        <div class="col-md-12 text-secondary">
                                                            @php
                                                                $departName = $departments
                                                                    ->where('id', $staff->department_id)
                                                                    ->pluck('name')
                                                                    ->first();
                                                            @endphp
                                                            <div class="depart-readonly @if (empty($departName) || $departName=='' ) hide @endif">
                                                                <input type="text" class="form-control readonly"
                                                                    value="{{ $departName }}" readonly>
                                                                <small class="form-text text-muted">Click to change</small>
                                                            </div>
                                                            <div class="depart-select @if (!empty($departName) || $departName !='' ) hide @endif">
                                                                <select id="my-select" class="custom-select"
                                                                    name="department_id">
                                                                    @foreach ($departments as $item)
                                                                        <option value="{{ $item->id }}" @if ($item->id == $staff->department_id) selected @endif>
                                                                            {{ $item->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row text-left">
                                                        <div class="col-md-12">
                                                            <h6 class="mb-0">Branch</h6>
                                                        </div>
                                                        <div class="col-md-12 text-secondary">
                                                            @php
                                                                $branchName = $branches
                                                                    ->where('id', $staff->branch_id)
                                                                    ->pluck('name')
                                                                    ->first();
                                                            @endphp


                                                            <div class="branch-readonly @if (empty($branchName) || $branchName=='' ) hide @endif">
                                                                <input type=" text" class="form-control readonly"
                                                                    value="{{ $branchName }}" readonly>
                                                                <small class="form-text text-muted">Click to change</small>
                                                            </div>

                                                            <div class="branch-select @if (!empty($branchName) || $branchName !='' ) hide @endif">
                                                                <select id="my-select" class="custom-select"
                                                                    name="branch_id">
                                                                    @foreach ($branches as $item)
                                                                        <option value="{{ $item->id }}" @if ($item->id == $staff->branch_id) selected @endif>
                                                                            {{ $item->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row text-left">
                                                        <div class="col-md-12">
                                                            <h6 class="mb-0">Position</h6>
                                                        </div>
                                                        <div class="col-md-12 text-secondary">
                                                            @php
                                                                $positionName = $position
                                                                    ->where('id', $staff->position)
                                                                    ->pluck('name')
                                                                    ->first();
                                                            @endphp


                                                            <div class="div-readonly @if (empty($positionName) || $positionName=='' ) hide @endif">
                                                                <input type=" text" class="form-control readonly"
                                                                    value="{{ $positionName }}" readonly>
                                                                <small class="form-text text-muted">Click to change</small>
                                                            </div>

                                                            <div class="div-select @if (!empty($positionName) || $positionName !='' ) hide @endif">
                                                                <select id="my-select" class="custom-select"
                                                                    name="position">
                                                                    @foreach ($position as $item)
                                                                        <option value="{{ $item->id }}" @if ($item->id == $staff->position_id) selected @endif>
                                                                            {{ $item->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row align-items-center">
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
                                    <div class="row align-items-center">
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
                                    <div class="row align-items-center">
                                        <h6 class="mb-1 col-md-3">Contact</h6>
                                        <div class="col-md-9 row align-items-center">
                                            <div class="col-md-6">
                                                <div class="col-12">
                                                    <small class="mb-0">Email</small>
                                                </div>
                                                <div class="col-12 text-secondary">
                                                    <input type="text" class="form-control editable"
                                                        value="{{ $staff->email }}" placeholder="Email Address"
                                                        name="email" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="col-12">
                                                    <small class="mb-0">Phone</small>
                                                </div>
                                                <div class="col-12 text-secondary">
                                                    <input type="text" class="form-control editable"
                                                        value="{{ $staff->phone }}" placeholder="Phone number"
                                                        name="phone" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row align-items-center">
                                        <h6 class="mb-1 col-md-3">DOB & Gender</h6>
                                        <div class="col-md-9 row align-items-center">
                                            <div class="col-md-6">
                                                <div class="col-12">
                                                    <small class="mb-0">DOB</small>
                                                </div>
                                                <div class="col-12 text-secondary @if (empty($staff->
                                                    dob)) hide @endif">
                                                    <input type="text" class="form-control readonly"
                                                        value="{{ Date('jS M Y', strtotime($staff->dob)) }}"
                                                        placeholder="Date of Birth" name="" readonly>
                                                    <small class="form-text text-muted">Click to change</small>
                                                </div>
                                                <div class="col-12 @if (!empty($staff->dob)) hide @endif">
                                                    <input id="dob" class="form-control" type="date" name="dob"
                                                        placeholder="Date of Birth*" value="{{ $staff->dob }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-12">
                                                    <small class="mb-0">Gender</small>
                                                </div>
                                                @php
                                                    $gender = $staff->gender;
                                                @endphp
                                                <div class="col-12 text-secondary @if ($gender==''
                                                    ) hide @endif">
                                                    <input type="text" class="form-control readonly"
                                                        value="{{ ucfirst($gender) }}" placeholder="Phone number" name=""
                                                        readonly>
                                                    <small class="form-text text-muted">Click to change</small>
                                                </div>
                                                <div class="col-12 @if ($gender !='' ) hide @endif">
                                                    <select id="gender" class="custom-select" name="gender">
                                                        <option value="male" @if ($gender == 'male') selected @endif>Male</option>
                                                        <option value="female" @if ($gender == 'female') selected @endif>Female</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <hr>
                                    <div class="row align-items-center">
                                        <h6 class="mb-1 col-md-3">Emergency Contact</h6>
                                        <div class="col-md-9 row align-items-center">
                                            <div class="col-md-6">
                                                <div class="col-12">
                                                    <small class="mb-0">Email</small>
                                                </div>
                                                <div class="col-12 text-secondary">
                                                    <input type="text" class="form-control editable"
                                                        value="{{ $staff->emergencyemail }}" placeholder="Email Address"
                                                        name="emergencyemail" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="col-12">
                                                    <small class="mb-0">Phone</small>
                                                </div>
                                                <div class="col-12 text-secondary">
                                                    <input type="text" class="form-control editable"
                                                        value="{{ $staff->emergencypno }}" placeholder="Phone number"
                                                        name="emergencypno" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row align-items-center">
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

                            <div class="row gutters-sm">
                                <div class="col-sm-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="bg-secondary text-white p-2 mb-3">
                                                Payment Info
                                            </h6>
                                            <small>Basic Salary</small>
                                            <div class="mb-3">
                                                <input type="text" class="form-control" name="basal"
                                                    value="{{ $staff->basal }}">

                                            </div>
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
                                                                    {{ $allowances->where('id', $item->allowance)->pluck('name')->first() }}
                                                                    <a href="/allowance/edit/{{ $item->id }}"
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
                                                                    {{ $deductions->where('id', $ded->deduction)->pluck('name')->first() }}
                                                                    <a href="/deduction/edit/{{ $ded->id }}"
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
                                <div class="col-sm-6 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="bg-secondary text-white p-2 mb-3"><i
                                                    class="fas fa-money-bill    "></i>
                                                &nbsp; Banking Info</h6>
                                            <div class="row align-items-center">
                                                <div class="col-12">
                                                    <h5>Primary Bank</h5>
                                                    @php
                                                        $priBank = $banks
                                                            ->where('id', $staff->bank)
                                                            ->pluck('name')
                                                            ->first();
                                                    @endphp
                                                    <small>Bank</small>
                                                    <div class="form-group  @if (empty($staff->bank)
                                                        || $staff->bank == '') hide @endif">
                                                        <input type="text" class="form-control readonly"
                                                            value="{{ $priBank }}" readonly>
                                                    </div>

                                                    <div class="form-group @if (!empty($staff->bank)
                                                        || $staff->bank != '') hide @endif">
                                                        <select name="bank" id="" class="custom-select">
                                                            @foreach ($banks as $item)
                                                                <option value="{{ $item->id }}" @if ($item->id == $staff->bank) selected @endif>
                                                                    {{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <small>Account No</small>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control readonly"
                                                            value="{{ $staff->account_no }}" name="bank">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <h5>Secondary Bank</h5>
                                                    @php
                                                        $bankName = $banks
                                                            ->where('id', $staff->secondary_bank)
                                                            ->pluck('name')
                                                            ->first();
                                                    @endphp
                                                    <small>Bank</small>
                                                    <div class="form-group  @if (empty($staff->
                                                        secondary_bank) || $staff->secondary_bank == '') hide @endif">
                                                        <input type="text" class="form-control readonly"
                                                            value="{{ $bankName }}" readonly>
                                                    </div>

                                                    <div class="form-group @if (!empty($staff->
                                                        secondary_bank) || $staff->secondary_bank != '') hide @endif">
                                                        <select name="secondary_bank" id="" class="custom-select">
                                                            @foreach ($banks as $item)
                                                                <option value="{{ $item->id }}" @if ($item->id == $staff->secondary_bank) selected @endif>
                                                                    {{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <small>Account No</small>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control readonly"
                                                            value="{{ $staff->secondary_acc }}" name="secondary_acc">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row gutters-sm my-2">
                        <div class="col-md-12">
                            <div class="card  bg-white p-4 col-12">
                                <div class="card-body col-12">
                                    <input type="submit" class="btn btn-primary btn-block btn-lg" value="Update">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('modals.edit-staff-pic')
@endsection
