<div id="printConfigModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="my-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered text-dark" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Printing Configuration</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/print" method="POST">
                    @csrf
                    <input type="hidden" name="document" value={{ $document }}>
                    <div class="row py-3 border rounded m-1 justify-content-center">
                        <div class="form-group col-12">
                            <label for="filter">Print Payroll for</label>
                            <select id="filter" class="custom-select" name="filter">
                                <option value="all">All Branches</option>
                                @foreach ($branches as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row flex-row text-white mt-2 align-items-center col-12">
                            <div class="form-group col-6">
                                <select id="filter_month" class="custom-select filter" name="month">
                                    @php
                                        $start = Date('01-01-2000');
                                        
                                    @endphp
                                    @for ($i = 0; $i < 12; $i++)
                                        @php $month = Date('m', strtotime('+' . $i . ' month', strtotime($start))); @endphp
                                        <option value="{{ $month }}" @if (Date('m') == $month) selected @endif>
                                            {{ Date('F', strtotime('+' . $i . ' month', strtotime($start))) }}
                                        </option>
                                    @endfor


                                </select>
                            </div>
                            <div class="form-group col-6">
                                <select id="filter_year" class="custom-select filter" name="year">
                                    @foreach ($years as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-10 mx-auto my-2">
                        <button class="btn btn-primary btn-block" type="submit" value="submit">Print</button>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div>
    </div>
</div>
