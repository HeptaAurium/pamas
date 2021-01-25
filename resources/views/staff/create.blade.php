@extends('layouts.app')

@section('title', 'New Staff')

@section('content')
    <div class="container px-3 py-3">
        <form action="/staff" method="POST" class="newStaffForm border-success pb-4" id="newStaffForm">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-6 bg-light border-right   py-4 ">
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
                                        <input id="secondarypno" class="form-control" type="text" name="secondarypno"
                                            placeholder="Secondary Phone Number">
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
                                    <div class="col-4">
                                        <input id="location" class="form-control" type="text" name="location"
                                            placeholder="Location">
                                    </div>
                                    <div class="col-4">
                                        <input id="estate" class="form-control" type="text" name="estate"
                                            placeholder="Estate/ Plot No">
                                    </div>
                                    <div class="col-4">
                                        <input id="houseno" class="form-control" type="text" name="houseno"
                                            placeholder="House No.">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bg-light py-4">
                        <h2 class="col-12 text-dark text-muted py-2 pl-0 mx-auto">Employment Info</h2>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="staff_unique_id">Staff ID</label>
                                <input id="staff_unique_id" class="form-control" type="text" name="staff_unique_id"
                                    placeholder="Staff ID No" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="national_id">National ID</label>
                                <input id="national_id" class="form-control" type="text" name="national_id"
                                    placeholder="National ID No" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                @if ($settings->multi_branch == 1)
                                    <div class="col-4">
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
                                <div class="col-4">
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
                                <div class="col-4">
                                    <div class="form-group">
                                        <label for="">Position</label>
                                        <select class="custom-select" name="position" id="" required>
                                            <option selected>Select department</option>
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
                                <input id="" class="form-control" type="text" name="basal" placeholder="Basic Salary"
                                    required>
                            </div>
                            <div class="form-group col-12">
                                <label for="tax_groups">Tax Groups</label>
                                <select id="tax_groups" class="custom-select" name="tax_groups" multiple required>
                                    @foreach ($tax_groups as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group col-12">
                                <label for="">File No.</label>
                                <input type="text" name="fileno" id="" class="form-control" placeholder="File Number"
                                    aria-describedby="helpId">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 bg-light py-4  my-2">

                        <div class="form-group my-2">
                            <label for="">Primary Bank</label>
                            <div class="row">
                                <div class="col-6">
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
                                </div>
                                <div class="col-6">
                                    <input id="account_no" class="form-control" type="text" name="account_no"
                                        placeholder="Primary account number" required>

                                </div>
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label for="">Secondary Bank</label>
                            <div class="row">
                                <div class="col-6">
                                    <select id="bank" class="custom-select" name="secondary_bank">
                                        @foreach ($banks as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <input id="" class="form-control" type="text" name="secondary_acc"
                                        placeholder="Secondary account number" required>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 my-2 py-5 bg-light">
                        <button class="btn btn-lg btn-success btn-block mt-3" type="submit">Save</button>
                        <button class="btn btn-secondary my-3" onclick="clearForm(newStaffForm)">Clear Form</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('layouts.navs.footer')
@endsection
