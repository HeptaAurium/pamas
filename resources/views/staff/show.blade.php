@extends('layouts.app')

@section('title', "{{ $staff->firstname . ' ' . $staff->lastname }}")

@section('content')
    <div class="staff-profiles px-3 py-3">
        <div class="container">
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
                                        <button class="btn btn-primary btn-block">Edit Details</button>
                                        <button class="btn btn-danger my-2"> <i class="fas fa-file-pdf    "></i> Print
                                            Profile Card</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $staff->firstname . ' ' . $staff->middlename . ' ' . $staff->lastname }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Staff ID</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $staff->staff_unique_id }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $staff->email }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $staff->phone }}
                                    </div>
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Home Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        {{ $staff->location . ', ' . $staff->estate . ', ' . $staff->houseno }}
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
                                            {{ number_format($staff->basal) }}
                                        </div>

                                        <h6 class="bg-secondary text-white p-2 mb-3"><i class="fas fa-money-bill    "></i>
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
                                        <h6 class="bg-secondary text-white p-2 mb-3">Alllowances</h6>
                                        <div class="row">
                                            <div class="col-3">
                                                <small>House</small>
                                                <div>
                                                    {{ number_format(303030) }}
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <small>House</small>
                                                <div>
                                                    {{ number_format(303030) }}
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <small>House</small>
                                                <div>
                                                    {{ number_format(303030) }}
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <small>House</small>
                                                <div>
                                                    {{ number_format(303030) }}
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <small>House</small>
                                                <div>
                                                    {{ number_format(303030) }}
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="bg-secondary text-white p-2 mb-3">Deductions</h6>
                                        <div class="row">
                                            <div class="col-3">
                                                <small>NHIF</small>
                                                <div>
                                                    {{ number_format(303030) }}
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <small>NSSF</small>
                                                <div>
                                                    {{ number_format(303030) }}
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <small>House</small>
                                                <div>
                                                    {{ number_format(303030) }}
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <small>House</small>
                                                <div>
                                                    {{ number_format(303030) }}
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <small>House</small>
                                                <div>
                                                    {{ number_format(303030) }}
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
        </div>
    </div>
@endsection
