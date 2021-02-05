<div class="row">
    <div class="col-sm-10 container bg-light  mx-auto text-dark  p-3" style="min-height:400px;">
        <div class="row px-md-4 border py-4">
            <div class="col-6">
                <h1 class="display col-12 bg-gradient-dark text-white p-3">Payslip</h1>
                <h3 class="display">{{ $staff->firstname . ' ' . $staff->middlename . ' ' . $staff->lastname }}
                </h3>

                <h6 class="font-weight-bold">Branch:
                    <span
                        class="font-weight-lighter">{{ $branches->where('id', $staff->branch_id)->pluck('name')->first() }}</span>
                </h6>
                <h6 class="font-weight-bold">Department:
                    <span
                        class="font-weight-lighter">{{ $departments->where('id', $staff->department_id)->pluck('name')->first() }}</span>
                </h6>
                <h6 class="font-weight-bold">Position:
                    <span
                        class="font-weight-lighter">{{ $positions->where('id', $staff->position)->pluck('name')->first() }}</span>
                </h6>
            </div>
            <div class="col-6 ">
                <div class="text-right">
                    @if (!empty($settings->business_logo) || $settings->business_logo != '')
                        <img src="{{ asset($settings->business_logo) }}" alt="" class="img-fluid w-auto"
                            style="height:90px;">
                    @endif
                    <h4>{{ $settings->business_name }}</h4>
                    <span>Payslip No: 000{{ $payroll->id . '|' . $payroll->month . $payroll->year }}</span>
                    <p class="font-weight-bold my-3">Date Processed:
                        <span class="font-weight-lighter">
                            {{ Date('l, jS F Y', strtotime($payroll->updated_at)) }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="col-6">
                <h4 class="bg-secondary text-white p-2">Allowances & Additions</h4>
                <table class="table table-active text-center table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Allowance</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i =1 @endphp
                        @foreach ($alls as $item)
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $allowances
                                    ->where('id', $item->allowance)
                                    ->pluck('name')
                                    ->first(); ?></td>
                                <td><?php echo $item->amount; ?></td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-6">
                <h4 class="bg-secondary text-white p-2" style="background-color: grey">Deductions</h4>
                <table class="table table-active text-center table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Deduction</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i =1 @endphp
                        @foreach ($deds as $item)
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $deductions
                                    ->where('id', $item->deduction)
                                    ->pluck('name')
                                    ->first(); ?></td>
                                <td><?php echo $item->amount; ?></td>
                            </tr>
                            @php $i++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <h4 class="bg-secondary text-white p-2">Payments</h4>
                <table class="table table-active text-center table-striped">
                    <thead>
                        <tr>
                            <th>Basic Salary</th>
                            <th>Total Additions</th>
                            <th>Total Deductions</th>
                            <th>Tax Relief</th>
                            <th>Tax <small>(after relief is deducted)</small></th>
                            {{-- <th>Net Pay</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo number_format($payroll->basal); ?></td>
                            <td><?php echo number_format($payroll->total_additions); ?>
                            </td>
                            <td><?php echo number_format($payroll->total_deductions); ?>
                            </td>
                            <td><?php echo number_format($settings->tax_relief); ?></td>
                            <td><?php echo number_format($payroll->tax); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-12 my-2">
                <h2 class="bg-primary float-right py-3 px-3 text-white ">Net Pay
                    <span> KSH {{ number_format($payroll->net_pay) }}</span>
                </h2>
            </div>
        </div>
    </div>
</div>
