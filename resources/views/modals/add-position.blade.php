<div id="addPositionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered text-dark" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPositionModal-title">Add Position</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/position" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Position Name</label>
                        <input type="text" class="form-control" name="name" id="" aria-describedby="helpId" placeholder="" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Position</button>
                </form>
            </div>
            <div class="modal-footer">
               <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
