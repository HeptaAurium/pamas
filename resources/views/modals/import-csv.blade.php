<div id="importCsvModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered text-dark" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDepartModal-title">Import Staff Members details from csv</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/staff/upload/csv" method="POST" enctype="multipart/form-data">
                    @csrf
                   <div class="custom-file">
                       <input id="csv" class="custom-file-input" type="file" name="csv" accept=".csv" required>
                       <label for="csv" class="custom-file-label">CSV File</label>
                   </div>
                    <button type="submit" name="submit" class="btn btn-success btn-block my-3">Import</button>
                </form>
                <button class="btn btn-secondary">
                    <i class="fa fa-cloud-download" aria-hidden="true"></i>
                    Download csv template
                </button>
            </div>
            <div class="modal-footer">
               <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
