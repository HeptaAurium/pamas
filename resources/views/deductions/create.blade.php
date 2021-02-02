@extends('layouts.app')

@section('title', 'Deductions ')

@section('content')
    <div class="container px-3 py-3">
        <h3 class="p-3">Add Deduction</h3>
        <div class="row">
            <div class="panel col-md-8 mx-auto mt-3 bg-light rounded border text-dark padding">
                <form action="/deduction" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Deduction Name</label>
                        <input type="text" class="form-control" name="name" id="" aria-describedby="helpId" placeholder="" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Deduction</button>
                </form>
            </div>
        </div>
    </div>
@endsection
