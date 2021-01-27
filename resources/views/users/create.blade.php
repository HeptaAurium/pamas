@extends('layouts.app')

@section('title', 'Add User ')

@section('content')
    <div class="container">
        <div class="panel my-3 row align-items-center py-5" style="min-height: 500px;">
            <form action="/user-management" method="POST" class="bg-light shadow rounded col-sm-11 col-md-8 p-4 my-3 mx-auto text-dark padding">
               
                <label for="" class="text-center display-4 w-100 text-muted">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                </label>
                <span class="text-muted font-italic text-center"> <small>All fields are required! Default password is the email provided, ask the user to change it as soon as they log in</small> </span>
                @csrf
                <div class="form-group mb-5">
                    <input type="text" name="name" id="" class="form-control" placeholder="User name" aria-describedby="helpId" required>
                </div>
                
                <div class="form-group my-4">
                    <input type="email" name="email" id="" class="form-control" placeholder="Email" aria-describedby="helpId">
                </div>
                

                <div class="form-group">
                    <select id="role" class="custom-select" name="role" required>
                        <option>Select role</option>
                        @foreach ($roles as $item)
                            <option value="{{$item->name}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-block btn-success" type="submit">Create User</button>
            </form>
        </div>
    </div>
@endsection
