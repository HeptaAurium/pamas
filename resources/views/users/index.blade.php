@extends('layouts.app')

@section('title', 'User Management ')

@section('content')
    <div class="container">
        <div class="row align-items-center padding" style="min-height: 400px;">
            <h3 class="p-4">Active Users</h3>
            <table
                class="table table-responsive-md table-light table-condensed table-striped text-dark col-md-11 mx-auto shadow rounded">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>User Role</th>
                        <th>Last Login</th>
                        <th>Online</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    @php $role = $user->roles->pluck('name')->first() @endphp
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $role }}</td>
                            <td>{{ $user->last_login }}</td>
                            <td>
                                @if ($user->online == 1)
                                    <span class="badge badge-success p-2">Online</span>
                                @else
                                    <span class="badge badge-secondary p-2">Offline</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button id="my-dropdown" class="btn bg-transparent text-dark dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                            class="fa fa-bars" aria-hidden="true"></i></button>
                                    <div class="dropdown-menu" aria-labelledby="my-dropdown">
                                        <a class="dropdown-item  @if($user->id==auth()->user()->id || $role=="Super-Admin") disabled @endif" href="/user-management/{{ $user->id }}/edit"> <i class="fas fa-pencil-alt"></i> Edit</a>
                                        <form action="/user-management/{{ $user->id }}" method="POST"
                                            id="delUser{{ $user->id }}">
                                            @method('DELETE')
                                            @csrf
                                            <a class="dropdown-item btnDeleteUser @if($user->id==auth()->user()->id || $role=="Super-Admin") disabled @endif" data-form_id="delUser{{ $user->id }}"
                                                type="submit"> <i class="fa fa-trash" aria-hidden="true"></i>
                                                Deactivate</a>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if (count($deactivated) > 0)
            <div class="row align-items-center mt-3 padding">
                <h3 class="p-4">Deactivated Users</h3>
                <table
                    class="table table-responsive-md table-light table-condensed table-striped text-dark col-md-11 mx-auto shadow rounded">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>User Role</th>
                            <th>Deactivation Date</th>
                            <th>Deactivated By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deactivated as $item)
                            <tr>
                                @php $del = $item->deleted_by; @endphp
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->roles->pluck('name')->first() }}</td>
                                <td>{{ Date('h:m a, d M Y ', strtotime($item->deleted_at)) }}</td>
                                <td>{{ \App\Helpers\GeneralHelper::get_user_name($del) }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button id="my-dropdown" class="btn bg-transparent text-dark dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                class="fa fa-bars" aria-hidden="true"></i></button>
                                        <div class="dropdown-menu" aria-labelledby="my-dropdown">
                                            <a class="dropdown-item " href="#">
                                                <i class="fa fa-reply" aria-hidden="true"></i>
                                                Restore</a>

                                                <a class="dropdown-item btnDeletePerm" data-user="{{ $item->id }}"
                                                    type="submit"> <i class="fa fa-stop" aria-hidden="true"></i>
                                                    Delete Permanently
                                                </a>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>
@endsection
