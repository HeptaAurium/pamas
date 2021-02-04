@extends('layouts.app')

@section('title', 'New Staff')

@section('content')
    <div class="container px-3 py-3">
        <form action="/staff" method="POST" class="newStaffForm border-success pb-4" id="newStaffForm">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-6 bg-light border-right my-2  py-4 ">
                        <h2 class="col-12 text-dark text-muted py-2 pl-0">Personal Info</h2>
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="my-input">Full Name</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <input id="fname" class="form-control" type="text" name="firstname"
                                            placeholder="First Name *" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="mname" class="form-control" type="text" name="middlename"
                                            placeholder="Middle Name">
                                    </div>
                                    <div class="col-md-4">
                                        <input id="lname" class="form-control" type="text" name="lastname"
                                            placeholder="Last Name *" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-12">
                                <label for="my-input">Contact</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input id="phone" class="form-control" type="text" name="phone"
                                            placeholder="Phone Number *" required>
                                    </div>
                                    <div class="col-6">
                                        <input id="secondarypno" class="form-control" type="tel" name="secondarypno"
                                            placeholder="Secondary Phone Number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="my-input">Date of Birth & Gender</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input id="dob" class="form-control" type="date" name="dob"
                                            placeholder="Date of Birth*" required>
                                    </div>
                                    <div class="col-6">
                                        <select id="gender" class="custom-select" name="gender">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-12">
                                <label for="my-input">Email address</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input id="email" class="form-control" type="email" name="email"
                                            placeholder="Email Address *" required>
                                    </div>
                                    <div class="col-6">
                                        <input id="secondaryemail" class="form-control" type="email" name="secondaryemail"
                                            placeholder="Secondary Email Address">
                                    </div>

                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="my-input">Emergency Contacts</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input id="emergencypno" class="form-control" type="tel" name="emergencypno"
                                            placeholder="Phone Number *" required>
                                    </div>
                                    <div class="col-6">
                                        <input id="emergencyemail" class="form-control" type="email" name="emergencyemail"
                                            placeholder="Email Address">
                                    </div>

                                </div>
                            </div>

                            <div class="form-group col-12">
                                <label for="my-input">Residence</label>
                                <div class="row">
                                    <div class="col-6 col-md-4">
                                        <input id="location" class="form-control" type="text" name="location"
                                            placeholder="Location" required>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <input id="estate" class="form-control" type="text" name="estate"
                                            placeholder="Estate/ Plot No" required>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <input id="houseno" class="form-control" type="text" name="houseno"
                                            placeholder="House No." required>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group col-12">
                                <label for="">File No.</label>
                                <input type="text" name="fileno" id="" class="form-control" placeholder="File Number"
                                    aria-describedby="helpId">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bg-light my-2 py-4">
                        <h2 class="col-12 text-dark text-muted py-2 pl-0 mx-auto">Employment Info</h2>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="staff_unique_id">Staff ID</label>
                                <input id="staff_unique_id" class="form-control" type="text" name="staff_unique_id"
                                    placeholder="Staff ID No" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="national_id">National ID</label>
                                <input id="national_id" class="form-control" type="number" name="national_id"
                                    placeholder="National ID No" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                @if ($settings->multi_branch == 1)
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Branch</label>
                                            <select class="custom-select" name="branch_id" id="" required>
                                                <option selected>Select branch</option>
                                                @foreach ($branches as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-sm btn-primary pull-right" data-toggle="modal"
                                                data-target="#addBranchModal"> <i class="fa fa-plus-square"
                                                    aria-hidden="true"></i> Add Branch </button>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Department</label>
                                        <select class="custom-select" name="department_id" id="" required>
                                            <option selected>Select department</option>
                                            @foreach ($departments as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#addDepartModal"> <i class="fa fa-plus-square"
                                                aria-hidden="true"></i> Add Department </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Position</label>
                                        <select class="custom-select" name="position" id="" required>
                                            <option selected>Select position</option>
                                            @foreach ($position as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#addPositionModal"> <i class="fa fa-plus-square"
                                                aria-hidden="true"></i> Add Position </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="">TSC No</label>
                                <input id="" class="form-control" type="text" name="tscno" placeholder="TSC No (optional)">
                            </div>
                            <div class="form-group col-6">
                                <label for="">Basic Salary *</label>
                                <input id="" class="form-control" type="number" name="basal" placeholder="Basic Salary"
                                    required>
                            </div>
                            <div class="form-group col-12">
                                <label for="tax_groups">Tax Groups</label>
                                <select id="tax_groups" class="custom-select" name="tax_groups" multiple required>
                                    @foreach ($tax_groups as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach

                                </select>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addTaxGroupModal">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i> Add TaxGroup </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 bg-light py-4  my-2">
                        <div class="form-group my-2 d-flex flex-column">
                            <label for="">Primary Bank</label>
                            <div class="row">
                                <div class="col-6">
                                    @if (count($banks) == 0)
                                        <select id="" class="custom-select" name="">
                                            <option>No banks added yet, please add banks before proceeding</option>
                                        </select>
                                    @else
                                        @if ($globals['hasPrimaryBank'])
                                            <input id="" class="form-control" type="text" name=""
                                                value="{{ $primary_bank->name }}" readonly>
                                            <input type="hidden" value="{{ $primary_bank->id }}" name="bank">
                                        @else
                                            <select id="bank" class="custom-select" name="bank">
                                                @foreach ($banks as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-6">
                                    <input id="account_no" class="form-control" type="number" name="account_no"
                                        placeholder="Primary account number" required>
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <button class="btn btn-sm btn-primary position-absolute my-3" style="bottom:0"
                                    data-toggle="modal" data-target="#addBankModal">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i> Add Bank
                                </button>
                            </div>

                        </div>
                        <div class="form-group my-2">
                            <label for="">Secondary Bank</label>
                            <div class="row">
                                <div class="col-6">
                                    @if (count($banks) == 0)
                                        <select id="" class="custom-select" name="">
                                            <option>No banks added yet, please add banks before proceeding</option>
                                        </select>
                                    @else
                                        <select id="bank" class="custom-select" name="secondary_bank">
                                            @foreach ($banks as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <input id="" class="form-control" type="number" name="secondary_acc"
                                        placeholder="Secondary account number" required>

                                </div>
                            </div>
                            <div class="col-12 mt-5">
                                <button class="btn btn-sm btn-primary position-absolute my-3" style="bottom:0"
                                    data-toggle="modal" data-target="#addBankModal">
                                    <i class="fa fa-plus-square" aria-hidden="true"></i> Add Bank
                                </button>
                            </div>
                        </div>
                    </div>
                    @if ($settings->allowance_grouping == 0)
                        <div class="bg-light col-md-6 position-relative border-right my-3 py-4" style="height: auto;">
                            <label for="">Allowances</label>
                            <div class="row">
                                @if (count($allowances) == 0)
                                    <div class="flex-center text-dark text-muted" style="height: 150px;">
                                        <h2 class="text-center p-2">Available allowances will appear here once added!</h2>
                                    </div>
                                @endif

                                @foreach ($allowances as $item)
                                    <div class="col-6 mb-2">
                                        <input id="" class="form-control allowance" type="number"
                                            name="{{ $item->id }}" placeholder="{{ $item->name }} Allowance">
                                    </div>

                                @endforeach
                                <input class="form-control" type="hidden" id="allowanceArray" name="allowances[]" value="">
                            </div>

                            <button class="btn btn-sm btn-primary position-absolute my-3" style="bottom:0"
                                data-toggle="modal" data-target="#addAllowanceModal">
                                <i class="fa fa-plus-square" aria-hidden="true"></i> Add Allowance
                            </button>
                        </div>
                    @endif
                    @if ($settings->deductions_grouping == 0)
                        <div class="bg-light col-md-6 position-relative my-3 py-4" style="height: auto;">
                            <label for="">Deductions</label>
                            @if (count($deductions) == 0)
                                <div class="flex-center" style="height: 150px;">
                                    <h2 class="display text-dark text-muted text-center p-2">Available deductions will
                                        appear here once added!</h2>
                                </div>
                            @endif
                            <div class="row">

                                @foreach ($deductions as $item)
                                    <div class="col-6 mb-2">
                                        <input id="" class="form-control deduction" type="number"
                                            name="{{ $item->id }}" placeholder="{{ $item->name }}">

                                    </div>

                                @endforeach
                                <input type="hidden" name="deductions" id="deductionArray">
                            </div>
                            <button class="btn btn-sm btn-primary position-absolute my-3" style="bottom:0"
                                data-toggle="modal" data-target="#addDeductionModal">
                                <i class="fa fa-plus-square" aria-hidden="true"></i> Add Deduction
                            </button>
                        </div>
                    @endif
                    <div class="col-12 my-2 py-5 bg-light">
                        <button class="btn btn-lg btn-success btn-block mt-3" type="submit">Save</button>
                        <button class="btn btn-secondary my-3" onclick="clearForm(newStaffForm)">Clear Form</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    {{-- Modals --}}
    @include('modals.add-branch')
    @include('modals.add-department')
    @include('modals.add-position')
    @include('modals.add-allowance')
    @include('modals.add-deduction')
    @include('modals.add-taxgroup')
    @include('modals.add-bank')

    {{--  --}}
    @include('layouts.navs.footer')
@endsection
