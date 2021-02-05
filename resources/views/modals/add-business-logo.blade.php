<div id="editBusinessLogo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered text-dark" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTaxGroupModal-title">Edit Image</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/settings/logo" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="settings_id" value="{{ $settings->id }}">
                    <div class="form-group">
                        <label for=""></label>
                        <input type="file" class="form-control-file" name="logo" id="" placeholder=""
                            aria-describedby="fileHelpId" requird>
                        {{-- <small id="fileHelpId" class="form-text text-muted">Help text</small> --}}
                    </div>

                    <button type="submit" class="btn btn-primary">Upload Image</button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
