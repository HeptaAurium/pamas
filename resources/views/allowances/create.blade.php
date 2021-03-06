@extends('layouts.app')

@section('title', 'Allowances ')

@section('content')
    <div class="container px-3 py-3">
        <h3 class="p-3">Add Allowance</h3>
        <div class="row">
            <div class="panel col-md-8 mx-auto mt-3 bg-light rounded border text-dark padding">
                <form action="/allowance" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Allowance Name</label>
                        <input type="text" class="form-control" name="name" id="" aria-describedby="helpId" placeholder="" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Allowance</button>
                </form>
            </div>
        </div>
    </div>
@endsection
