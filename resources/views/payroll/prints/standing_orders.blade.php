<!DOCTYPE html>
<html lang="en">

<head>
    @include('payroll.prints.css')
</head>

<body>
    {{-- @include('payroll.prints.header') --}}
    <header>
        @if (!empty($settings->business_logo) || $settings->business_logo != '')
            @php
                $path = public_path() . $settings->business_logo;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            @endphp
            <img src="{{ $base64 }}" style="height:50px;width:auto;margin:0;float:left;" />
        @endif
        <div class="headers">
            <h2>{{ $settings->business_name }}</h2>
            <h5>Payroll for {{ $date }}</h5>
        </div>
    </header>
    <table class="table text-center table-sm table-condensed" id="payroll_processed" style="">
        <thead>
            <tr>
                <th>Staff Name</th>
                <th>Branch</th>
                <th>Basic Salary</th>
                <th>Total Allowances</th>
                <th>Total Deductions</th>
                <th>Taxation</th>
                <th>Net Pay</th>
                <th>Date Processed</th>
            </tr>
        </thead>
        <tbody id="payroll_data">
            <?php foreach ($payrolls as $item):

            $stff = $staff->where('id', $item->staff_id)->first();
            $name = $stff->firstname . ' ' . $stff->lastname;
            $brnch = $stff->branch_id;

            if ($request->filter != 'all') {
            if ($brnch != $request->filter) {
            continue;
            }
            }
            ?>
            <tr>
                <td class="text-left"><?php echo $name; ?></td>
                <td><?php echo $branches
                    ->where('id', $brnch)
                    ->pluck('name')
                    ->first(); ?></td>
                <td><?php echo number_format($item->basal); ?></td>
                <td><?php echo number_format($item->total_additions); ?></td>
                <td><?php echo number_format($item->total_deductions); ?></td>
                <td><?php echo number_format($item->tax); ?></td>
                <td><?php echo number_format($item->net_pay); ?></td>
                <td><?php echo Date('jS M Y ', strtotime($item->updated_at)); ?></td>
            </tr>

            <?php
            endforeach; ?>

        </tbody>
    </table>

    <footer style="width: 100%;" id="footer">
        <hr>
        <p>&copy; {{ Date('Y') }} - {{ $settings->business_name }} <br> This document is computer generated and
            hence might not be signed
            <br>Generated on {{ Date('l, jS F Y') . ' at ' . Date('h:i:s a') }}
        </p>
    </footer>
</body>

</html>
