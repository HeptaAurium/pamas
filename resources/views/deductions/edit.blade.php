@extends('layouts.app')

@section('title', 'Deductions ')

@section('content')
    <div class="container px-3 py-3">
        <h3 class="p-3">Edit Deduction</h3>
        <div class="row">
            <div class="panel col-md-8 mx-auto mt-3 bg-light rounded border text-dark padding">
                <form action="/deduction/{{ $deduction->id }}" method="POST" class="d-flex flex-column">
                    @csrf
                    @method('put')
                    <div class="form-group col-12">
                        <label for="name">Name</label>
                        <input id="name" class="form-control" type="text" name="name" value="{{ $deduction->name }}"
                            required>
                    </div>
                    <div class="col-12 form-group">
                        <button type="submit" class="btn btn-primary btn-block my-2">Save</button>
                        <a href="/deduction" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
