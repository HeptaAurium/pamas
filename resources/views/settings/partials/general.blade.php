<h3 class="p-2">Basics</h3>
<form action="/settings/update" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $settings->id }}">
    <div class="row px-3 text-dark justify-content-evenly">
        <div class="col-sm-11 col-md-4  col-md-offset-2 my-1">
            <div class="form-group p-2 rounded border bg-light">
                <label for="business_name" class="display">Business Name</label>
                <input id="business_name" class="form-control" type="text" name="business_name"
                    value="{{ $settings->business_name }}" required>
            </div>
        </div>
        <div class="col-sm-11 col-md-4  col-md-offset-2 my-1">
            <div class="form-group p-2 rounded border bg-light">
                <label for="multi_branch" class="display">Business has multiple branches</label>
                <select name="multi_branch" id="" class="custom-select">
                    <option value="1" @if ($settings->multi_branch === 1) selected @endif>Yes, Business has multiple branches</option>
                    <option value="0" @if ($settings->multi_branch !== 1) selected @endif>No, Business has only one branch</option>
                </select>
            </div>
        </div>

        <div class="col-sm-11 col-md-4  col-md-offset-2 my-1">
            <div class="form-group p-2 rounded border bg-light">
                <label for="tax_relief" class="display">Tax Relief</label>
                <input id="tax_relief" class="form-control" type="text" name="tax_relief"
                    value="{{ $settings->tax_relief }}" required>
            </div>
        </div>
        {{-- <div class="col-sm-11 col-md-6  col-md-offset-2 my-1">
                    <div class="form-group p-2 rounded border bg-light flex-center"
                        style="height: 117px;">
                        <div class="custom-file">
                            <input id="logo" class="custom-file-input" type="file" name="logo">
                            <label for="logo" class="custom-file-label">Business Logo</label>
                        </div>
                    </div>
                </div> --}}
        <div class="col-sm-11 col-md-4  col-md-offset-2 my-1">
            <div class="form-group p-2 rounded border bg-light">
                <label for="taxation" class="display">Include taxation</label>
                <select name="taxation" id="" class="custom-select">
                    <option value="1" @if ($settings->include_income_tax == 1) selected @endif>Yes</option>
                    <option value="0" @if ($settings->include_income_tax != 1) selected @endif>No</option>
                </select>
            </div>
        </div>
        <div class="col-12">
            <button class="btn btn-success btn-lg btn-block mx-auto mt-5" type="submit">Save</button>
        </div>
    </div>
</form>

