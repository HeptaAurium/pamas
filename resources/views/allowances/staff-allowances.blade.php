@extends('layouts.app')

@section('title', 'Allowances ')

@section('content')
    <div class="container px-3 py-3">
        <h3 class="p-3">Edit Allowance</h3>
        <div class="row">
            <div class="panel col-md-8 mx-auto mt-3 bg-light rounded border text-dark padding">
                <form action="/allowance/update" method="POST" class="d-flex flex-column">
                    @csrf
                    {{-- @method('put') --}}

                    <div class="row">
                        <div class="col-md-6 p-2">
                            <div class="border p-2 rounded padding">
                                <h5>Staff Details</h5>
                                <label for="" class="col-12"> Name:
                                    <span class="font-weight-bolder float-right">
                                        {{ $staff->firstname . ' ' . $staff->middlename . ' ' . $staff->lastname }}
                                    </span>
                                </label>
                                <label class="col-12"> Department:
                                    <span class="font-weight-bolder float-right">
                                        {{ $departments->where('id', $staff->department_id)->pluck('name')->first() }}
                                    </span>
                                </label>
                                <label class="col-12"> Branch:
                                    <span class="font-weight-bolder float-right">
                                        {{ $branches->where('id', $staff->branch_id)->pluck('name')->first() }}
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 p-1 pl-2 pr-2">
                            <div class="border rounded p-2">
                            <h5>Allowance Details</h5>
                            {{-- @foreach ($allowance as $allowance) --}}
                            <div class="form-group col-12">
                                <label for="name">
                                    {{ $allowances->where('id', $allowance->allowance)->pluck('name')->first() }}
                                </label>
                                <input id="" class="form-control" type="text" name="allowance"
                                    value="{{ $allowance->amount }}" required>
                            </div>
                            {{-- @endforeach --}}
                            </div>

                        </div>
                    </div>
                    <input type="hidden" name="allowance_id" value="{{ $allowance->id }}">
                    <div class="col-12 form-group">
                        <button type="submit" class="btn btn-primary btn-block my-2">Save</button>
                        <a href="/allowance" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
