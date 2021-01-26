<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Bank;
use App\Models\Business;
use App\Models\Deduction;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessController extends Controller
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
        return view('settings.business', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $business)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        //
    }
}
