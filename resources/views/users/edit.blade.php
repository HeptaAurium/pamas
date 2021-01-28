@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="container px-3 py-3">
        <div class="panel row align-items-center padding ">
            <form action="/user-management/{{ $user->id }}" method="POST"
                class="col-md-8 mx-auto padding text-dark bg-light shadow-lg rounded py-3">
                @csrf
                @method('put')
                <label for="" class="text-center display-4 w-100 text-muted" style="font-size:1.8rem;">
                    <i class="fa fa-user" aria-hidden="true"></i> <i class="fas fa-pencil-alt    "></i>
                </label>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" name="name" id="username" value="{{ $user->name }}" class="form-control"
                        placeholder="" required>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" id="" value="{{ $user->email }}" class="form-control" placeholder=""
                        readonly>
                </div>
                @php $role = $user->roles->pluck('name')->first() @endphp
                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" class="custom-select" name="role" required>
                        @foreach ($roles as $item)
                            @php
                            if(auth()->user()->roles->pluck('name')->first() != 'Super-Admin'){
                            if($item->name == "Super-Admin"){
                            continue;
                            }
                            }
                            @endphp
                            <option value="{{ $item->name }}" @if ($role == $item->name)
                                selected
                        @endif >{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" id="btnEditUser" class="btn btn-primary btn-block">Save</button>
            </form>
        </div>
    </div>
@endsection
