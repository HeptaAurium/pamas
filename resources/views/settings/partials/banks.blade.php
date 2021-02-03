<h3 class="p-2">Banks</h3>

<div class="row">
    <div class="col-md-10 ml-auto mr-auto">
        <table
            class="table table-hover table-borderered table-striped table-sm  rounded  table-light text-dark text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bank</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banks as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="flex-center">
                            <button data-toggle="modal" data-target="#editBankModal{{ $item->id }}"
                                class="btn bg-transparent">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <a href="javascript:void(0)" data-form_id="bank{{ $item->id }}"
                                class="btn bg-transparent btnDepartDel">
                                <i class="fas fa-trash"></i>
                            </a>
                            <form action="/bank/{{ $item->id }}" id="bank{{ $item->id }}" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                            @include('modals.edit-bank')
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <form action="/bank/update/primary" method="POST" class="text-dark mt-3">
            @csrf
            {{-- @method('put') --}}
            {{-- <input type="hidden" name="bank_id" value="{{ $item->id }}"> --}}
            <div class="form-group p-2 rounded border bg-light">
                <label for="bank" class="display"> Configure Primary Bank</label>
                <select name="bank" id="" class="custom-select">
                    <option value="0">No primary Bank</option>
                    @if (count($banks) == 0)
                        <option>Registered banks will be shown here</option>
                    @else
                        @foreach ($banks as $item)
                            <option value="{{ $item->id }}" @if ($item->is_primary == 1) selected @endif>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
