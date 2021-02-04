<h3 class="p-2">Positions</h3>

<div class="row">
    <div class="col-md-10 ml-auto mr-auto">
        <table
            class="table table-hover table-borderered table-striped table-sm  rounded  table-light text-dark text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Position</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($position as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td class="flex-center">
                            <button data-toggle="modal" data-target="#editPositionModal{{ $item->id }}"
                                class="btn bg-transparent">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <a href="javascript:void(0)" data-form_id="position{{ $item->id }}"
                                class="btn bg-transparent btnDepartDel">
                                <i class="fas fa-trash"></i>
                            </a>
                            <form action="/position/{{ $item->id }}" id="position{{ $item->id }}" method="POST">
                                @csrf
                                @method('delete')
                            </form>
                            @include('modals.edit-position')
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
