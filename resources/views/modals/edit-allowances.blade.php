<div id="editAllowanceModal{{ $item->id }}" class="modal" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered text-dark" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Edit allowances for {{ $name }}</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/edit/allowance" method="POST">
                    @csrf
                    <input type="hidden" name="staff_id" value={{$item->id}}>
                    <div class="row py-3 border rounded m-1 justify-content-center">
                        @foreach ($staff_allowances->where('staff_id', $item->id) as $item)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="{{ $item->allowance }}">
                                        {{ $allowances->where('id', $item->allowance)->pluck('name')->first() }}
                                    </label>
                                    <input class="form-control" type="number" name="{{ $item->allowance }}"
                                        value="{{ $item->amount }}">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-10 mx-auto my-2">
                        <button class="btn btn-primary btn-block" type="submit" value="submit">Save</button>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>
