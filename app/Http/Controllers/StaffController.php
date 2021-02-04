<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Bank;
use App\Models\Deduction;
use App\Models\SystemSetting;
use App\Models\Staff;
use App\Models\StaffAllowance;
use App\Models\StaffDeduction;
use Doctrine\DBAL\Query\QueryException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Yajra\Datatables\Facades\Datatables;
use Datatables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Sentry\Serializer\Serializer;
use Sentry\ClientBuilderInterface;
use Sentry;
use Carbon\Carbon;

class StaffController extends Controller
{
    protected $data;

    public function __construct()
    {
        global $data;
        $hasPrimaryBank = true;

        $this->data = &$data;
        $this->data['settings'] = SystemSetting::find(1);
        $this->data['tax_groups'] = DB::table('tax_groups')->get();
        $this->data['departments'] = DB::table('departments')->get();
        $this->data['branches'] = DB::table('branches')->get();
        $this->data['position'] = DB::table('staff_positions')->get();
        $this->data['banks'] = Bank::get();
        $this->data['allowances'] = Allowance::get();
        $this->data['deductions'] = Deduction::get();
        $this->data['primary_bank'] = Bank::where('is_primary', 1)->first();
        if ($this->data['settings']->has_primary_bank != 1) {
            $hasPrimaryBank = false;
        }
        $this->data['globals']['hasPrimaryBank'] = $hasPrimaryBank;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $this->data['staff'] = [];
        $staff = Staff::where('active', 1)->get();

        foreach ($staff as $st) {
            $array = [
                'id' => $st->id,
                'name' => $st->firstname . " " . $st->middlename . " " . $st->lastname,
                'department' => DB::table('departments')->where('id', $st->department_id)->pluck('name')->first(),
                'branch' => DB::table('branches')->where('id', $st->branch_id)->pluck('name')->first(),
                'phone' => $st->phone,
                'email' => $st->email,
                'position' => DB::table('staff_positions')->where('id', $st->position)->pluck('name')->first(),
            ];

            array_push($this->data['staff'], $array);
        }

        // return Datatables::of($this->data['staff'])->make(true);

        return view('staff.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //


        return view('staff.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $errors = [];
        $request->validate([
            'staff_unique_id' => 'bail|required|unique:staff,staff_unique_id',
            'national_id' => 'bail|required|unique:staff,national_id',
            'tscno' => 'bail|sometimes|unique:staff,tscno',
        ]);

        $input = $request->except('_token');

        try {
            $staff = Staff::create($input);
            $staff_id = $staff->id;
            // get allowances and deductions if specific allowed
            $setting = $this->data['settings'];


            if ($setting->allowance_grouping == 0) {
                $allowances = Allowance::get();
                foreach ($allowances as $allowance) {
                    $allow_id = $allowance->id;
                    $amount = $request->$allow_id;
                    $amount == "" || empty($amount) ? $amount = 0 : $amount = $amount;

                    DB::table('staff_allowances')->insert([
                        'staff_id' => $staff_id,
                        'allowance' => $allow_id,
                        'amount' =>  $amount,
                        'created_at' => Date('Y-m-d H:i:s'),
                        'updated_at' => Date('Y-m-d H:i:s')
                    ]);
                }
            }

            if ($setting->deductions_grouping == 0) {
                $deductions = Deduction::get();
                foreach ($deductions as $deduction) {
                    $ded_id = $deduction->id;
                    $amount = $request->$ded_id;
                    $amount == "" || empty($amount) ? $amount = 0 : $amount = $amount;
                    DB::table('staff_deductions')->insert([
                        'staff_id' => $staff_id,
                        'deduction' => $amount,
                        'amount' => $request->$ded_id,
                        'created_at' => Date('Y-m-d H:i:s'),
                        'updated_at' => Date('Y-m-d H:i:s'),
                    ]);
                }
            }

            flash('Staff member successfully added!')->success();
        } catch (\Throwable $th) {
            \LOG::error($th);
            flash('An error was encountered while processing your request! Try again later!')->success();
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
        $this->data['staff'] = [];
        $this->data['deduction'] = [];
        $this->data['allowance'] = [];

        // $this->data['staff'] = Staff::where('id', $staff->id)->first();
        $this->data['staff'] =  $staff;
        $this->data['staff']['department'] = DB::table('departments')->where('id', $staff->department_id)->pluck('name')->first();
        $this->data['staff']['branch'] = DB::table('branches')->where('id', $staff->branch_id)->pluck('name')->first();
        $this->data['staff']['position'] = DB::table('staff_positions')->where('id', $staff->position)->pluck('name')->first();
        $this->data['staff']['bank'] = DB::table('banks')->where('id', $staff->bank)->pluck('name')->first();
        $this->data['staff']['sec_bank'] = DB::table('banks')->where('id', $staff->secondary_bank)->pluck('name')->first();
        $this->data['staff']['age'] = Carbon::parse(strtotime($staff->dob))->age;

        $setting = $this->data['settings'];

        if ($setting->allowance_grouping == 0) {
            $staff_allowances = DB::table('staff_allowances')->where('staff_id', $staff->id)->get();
            foreach ($staff_allowances as $item) {
                $array = [
                    'name' => Allowance::where('id', $item->allowance)->pluck('name')->first(),
                    'amount' => $item->amount,
                    'id' => $item->id,
                ];

                array_push($this->data['allowance'], $array);
            }
        }
        if ($setting->deduction_grouping == 0) {
            $staff_deductions = DB::table('staff_deductions')->where('staff_id', $staff->id)->get();
            foreach ($staff_deductions as $item) {
                $array = [
                    'name' => Deduction::where('id', $item->deduction)->pluck('name')->first(),
                    'amount' => $item->amount
                ];

                array_push($this->data['deduction'], $array);
            }
        }

        return view('staff.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        //
        $this->data['staff'] = $staff;
        $this->data['allowance'] = StaffAllowance::where('staff_id', $staff->id)->get();
        $this->data['deduction'] = StaffDeduction::where('staff_id', $staff->id)->get();


        return view('staff.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staff $staff)
    {
        //
        $inputs = $request->except(['_token', '_method']);
        $updates = [];

        foreach ($inputs as $key => $value) {
            $original = $staff->getOriginal($key);

            if ($original != $value) {
                $staff->$key = $value;
            }
        }
        if ($staff->save()) {
            flash(trans('feedback.update_success'))->success();
        } else {
            flash(trans('feedback.update_error'))->error();
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staff $staff)
    {
        //

        $staff->active = 0;
        $staff->deleted_at = Date('Y-m-d H:i:s');
        $staff->save();
        flash('Staff Member deactivated')->success();


        return back();
    }

    // Edit allowances

    public function edit_allowance(Request $request)
    {


        $allowances = Allowance::get();
        foreach ($allowances as $allowance) {
            $all_id = $allowance->id;
            $st_all = StaffAllowance::where('staff_id', $request->staff_id)->where('allowance', $all_id)->first();

            $st_all->amount = $request->$all_id;
            $st_all->save();
        }

        return back();
    }

    public function edit_deduction(Request $request)
    {
        $deductions = Deduction::get();
        foreach ($deductions as $deduction) {
            $all_id = $deduction->id;
            $st_all = StaffDeduction::where('staff_id', $request->staff_id)->where('deduction', $all_id)->first();
            $st_all->amount = $request->$all_id;
            $st_all->save();
        }

        return back();
    }

    // Upload csv

    public function upload_csv(Request $request)
    {
        // dd($request);
        $file = $request->file('csv');

        // File Details
        $filename = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $tempPath = $file->getRealPath();
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Valid File Extensions
        $valid_extension = array("csv");

        // 2MB in Bytes
        $maxFileSize = 2097152;

        // Check file extension
        if (in_array(strtolower($extension), $valid_extension)) {

            // Check file size
            if ($fileSize <= $maxFileSize) {

                // File upload location
                $location = 'uploads';

                // Upload file
                $file->move($location, $filename);

                // Import CSV to Database
                $filepath = public_path($location . "/" . $filename);

                // Reading file
                $file = fopen($filepath, "r");

                $importData_arr = array();
                $i = 0;

                while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                    $num = count($filedata);

                    // Skip first row (Remove below comment if you want to skip the first row)
                    /*if($i == 0){
                      $i++;
                      continue;
                   }*/
                    for ($c = 0; $c < $num; $c++) {
                        $importData_arr[$i][] = $filedata[$c];
                    }
                    $i++;
                }
                fclose($file);
                $i = 0;
                // Insert to MySQL database
                foreach ($importData_arr as $importData) {
                    if ($i == 0) {
                        continue;
                    }
                    $insertData = array(
                        "staff_unique_id" => $importData[0],
                        "national_id" => $importData[1],
                        "firstname" => $importData[2],
                        "middlename" => $importData[3],
                        "lastname" => $importData[4],
                        "phone" => $importData[5],
                        "email" => $importData[6],
                        "basal" => $importData[7],
                        "emergencypno" => $importData[8],
                        "emergencyemail" => $importData[9],
                        "accountno" => $importData[10],
                        "active" => 1,
                    );
                    Staff::insertData($insertData);
                    $i++;
                }

                flash('Import Successful.')->success();
            } else {
                flash('File too large. File must be less than 2MB.')->error();
            }
        } else {
            flash('Invalid File Extension.')->error();
        }
        // Redirect to index
        return back();
    }

    public function profile(Request $request)
    {
        if ($request->hasFile('profile')) {
            //

            $staff = Staff::find($request->staff_id);
            try {
                //code...
                // $path = $request->file('profile')->storeAs(
                //     'staff',
                //     $request->file('profile')->getClientOriginalName(),
                //     'public'
                // );

                $destinationPath = '/img/staff/';
                $file = $request->file('profile');
                $filename = $file->getClientOriginalName();
                $file->move(public_path() . $destinationPath, $filename);
                $path = $destinationPath . $filename;

                $staff->photo = $path;

                if ($staff->save()) {
                    flash(trans('feedback.upload_success'))->success();
                }
            } catch (\Throwable $th) {
                //throw $th;
                \Log::error($th);
                flash(trans('feedback.upload_error'))->error();
            }
        } else {
            flash('Please provide a valid photo!')->warning();
        }

        return back();
    }
}
