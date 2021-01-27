@extends('layouts.app')

@section('title', 'User Roles ')

@section('content')
    <div class="container mt-5">
        <div class="panel bg-light m-2 shadow">
            <table class="table">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Permission</th>
                    </tr>
                </thead>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            <ul class="nav flex-column">
                                @foreach ($permissions as $item)
                                    <li class="my-2">
                                        <div class="btn-group-toggle" data-toggle="buttons">
                                            {{-- <input type="checkbox" name="{{ $item->id }}">  --}}
                                            <input type="checkbox" name="{{ $item->id }}"  />
                                            <label class="checkbox-label" for="{{$item->id}}">{{ $item->name }}</label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>
@endsection
