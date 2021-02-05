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
        <div class="col-sm-11 col-md-4  col-md-offset-2 my-1">
            <div class="form-group p-2 rounded border bg-light">
                <label for="" class="display">Business Logo</label>
                <div class="flex-center position-relative">
                    @if (empty($settings->business_logo) || $settings->business_logo == '')
                        <div class="rounded-circle flex-center bg-secondary my-2 p-2 shadow edit-pic"
                            style="width:150px;height:150px;">
                            <h1 class="display-4 text-light" style="font-family: 'Yusei Magic', sans-serif;">
                                <span>{{ $settings->business_name[0] }}</span></span>
                            </h1>
                        </div>
                    @else
                        <img src="{{ asset($settings->business_logo) }}" class="rounded-circle profile-pic edit-pic"
                            width="150">
                    @endif
                    <div class="prof-img-div flex-center">
                        <button class="btn bg-transparent" data-toggle="modal" data-target="#editBusinessLogo"
                            type="button">
                            <i class="fa fa-camera-retro" aria-hidden="true"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>
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
@include('modals.add-business-logo')
