@extends('layouts.app')

@section('title', 'Branches ')

@section('content')
    <div class="container px-3 py-3">
        <h3 class="p-3">Branches</h3>

        <table class="table table-striped  table-bordered table-dark table-sm">
            <thead>
                <tr>
                    <th scope="col">Branch Id</th>
                    <th scope="col">Name</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($branches as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="text-center text-md-left">
                            <div class="row">
                                <div class="col-md-6 my-1 px-3">
                                    <a href="/branch/{{ $item->id }}/edit"
                                        class="btn btn-success btn-sm flex-center">
                                        <i class="fas fa-pencil-alt"></i> &nbsp; &nbsp; &nbsp;
                                        <span class="d-none d-lg-block"> Edit</span>
                                    </a>
                                </div>
                                <div class="col-md-6 my-1 px-3">
                                    <a href="#" class="btn btn-danger btn-sm flex-center btnDepartDel"
                                        data-form_id="branch{{ $item->id }}">
                                        <i class="fas fa-trash"></i>&nbsp; &nbsp; &nbsp;
                                        <span class="d-none d-lg-block"> Discard</span>
                                    </a>
                                </div>
                                <form action="/branch/{{ $item->id }}" method="POST" id="branch{{ $item->id }}">
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
@endsection
