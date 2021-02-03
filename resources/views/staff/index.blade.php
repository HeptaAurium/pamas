@extends('layouts.app')

@section('title', 'Staff')

@section('content')
    <div class="container px-3 py-3">
        <div class="fd-lex flex-row">
            <a href="/staff/create" class="btn btn-primary"> <i class="fa fa-plus-square" aria-hidden="true"></i> Add New
                Staff </a>
            <button data-toggle="modal" data-target="#importCsvModal" class="btn btn-success"> <i
                    class="fas fa-file-csv"></i> Import CSV </button>
        </div>

        <table class="table table-condensed table-striped table-responsive-md table-hover text-dark table-light data-table"
            id="staff_tbl">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Branch</th>
                    <th>Department</th>
                    <th>Position</th>
                    <th>Phone No</th>
                    <th>Email Address</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($staff as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ empty($item['branch']) ? __('N/A') : $item['branch'] }}</td>
                        <td>{{ empty($item['department']) ? __('N/A') : $item['department'] }}</td>
                        <td>{{ $item['position'] }}</td>
                        <td>{{ $item['phone'] }}</td>
                        <td>{{ $item['email'] }}</td>
                        <td><span class="badge badge-success py-1 px-4">Active</span></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-transparent dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="/staff/{{ $item['id'] }}">View Details</a>
                                    <a class="dropdown-item" href="/staff/{{ $item['id'] }}/edit">Edit</a>
                                    <form action="/staff/{{ $item['id'] }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn dropdown-item" type="submit">Deactivate</button>
                                    </form>

                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @include('modals.import-csv')
@endsection
