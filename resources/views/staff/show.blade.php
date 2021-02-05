@extends('layouts.app')
@php $staff_name = $staff->firstname . ' ' . $staff->lastname @endphp
@section('title', $staff_name)

@section('content')
    <div class="staff-profiles px-3 py-3">
        <div class="container">
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
                                        <p class="text-secondary mb-1">{{ $staff['position'] }}</p>
                                        <p class="text-muted font-size-sm mb-1">
                                            {{ $staff['department'] . ', ' . $staff['branch'] }}
                                        </p> 
                                        <p class="text-muted font-size-sm mb-1">
                                            Gender : {{ ucfirst($staff->gender) }} <br>
                                            Age: {{$staff['age']}} years
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

                                        <div class="pb-2">
                                            <h6 class="bg-secondary text-white p-2 mb-4 align-items-center">Allowances
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
                                                                    class="btn float-right p-0"> <i class="fa fa-pencil-alt"
                                                                        aria-hidden="true"></i> </a>
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
                                                                    href="/deduction/edit/{{ $ded['id'] }}"
                                                                    class="btn float-right p-0"> <i class="fa fa-pencil-alt"
                                                                        aria-hidden="true"></i> </a>
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
        </div>
    </div>
    @include('modals.edit-staff-pic')
@endsection
