@extends('layouts.app')

@section('title', 'Allowances ')

@section('content')
    <div class="container">
        <div class="row px-3">
            <div class="panel col-12 my-3 mx-auto bg-light text-dark padding rounded shadow-sm">
                <h3 class="p-3">Allowances</h3>

                <table class="table table-striped  table-bordered text-dark table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Allowance Id</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($allowances) < 1)
                            <tr rowspan="3">
                                <td colspan="3" class="text-center">
                                    <h2 class="display-4 text-muted p-3">No allowances yet!</h2>
                                </td>
                            </tr>
                        @endif
                        @foreach ($allowances as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td class="text-center text-md-left">
                                    <div class="row">
                                        <div class="col-md-6 my-1 px-3">
                                            <a href="/allowance/{{ $item->id }}/edit"
                                                class="btn btn-success btn-sm flex-center">
                                                <i class="fas fa-pencil-alt"></i> &nbsp; &nbsp; &nbsp;
                                                <span class="d-none d-lg-block"> Edit</span>
                                            </a>
                                        </div>
                                        <div class="col-md-6 my-1 px-3">
                                            <a href="#" class="btn btn-danger btn-sm flex-center btnDepartDel"
                                                data-form_id="allowance{{ $item->id }}">
                                                <i class="fas fa-trash"></i>&nbsp; &nbsp; &nbsp;
                                                <span class="d-none d-lg-block"> Discard</span>
                                            </a>
                                        </div>
                                        <form action="/allowance/{{ $item->id }}" method="POST"
                                            id="allowance{{ $item->id }}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel col-12 my-3 mx-auto bg-light text-dark padding rounded shadow-sm">
                <h3>Staff Allowances</h3>

                <table class="table table-striped  table-bordered text-dark table-sm dedall" id="staff_allowance">
                    <thead>
                        <tr>
                            <th scope="col">Staff</th>
                            <th scope="col">Allowance</th>
                            <th scope="col">Amount</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staff_allowances as $item)
                            @php
                                $stff = $staff->where('id', $item->staff_id)->first();
                                $allowance_name = $allowances
                                    ->where('id', $item->allowance)
                                    ->pluck('name')
                                    ->first();
                                if ($allowance_name == '' || empty($allowance_name)) {
                                    continue;
                                }
                            @endphp
                            <tr>
                                <td>{{ $stff->firstname . ' ' . $stff->lastname }}</td>
                                <td>{{ $allowance_name }}</td>
                                <td>{{ empty($item->amount) ? 0 : number_format($item->amount) }}</td>
                                <td class="text-center">
                                    <a href="/allowance/edit/{{ $item->id }}"
                                        class="btn btn-primary btn-sm flex-center w-75 m-auto">
                                        <i class="fas fa-pencil-alt"></i> &nbsp;&nbsp;&nbsp;
                                        <span class="d-none d-md-block">Edit</span>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
