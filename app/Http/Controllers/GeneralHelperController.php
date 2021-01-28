<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\StaffAllowance;
use Illuminate\Http\Request;

class GeneralHelperController extends Controller
{
    //
    protected $data;

    public function __construct()
    {
        global $data;
        $this->data = &$data;

        $this->data['staff_allowances'] = StaffAllowance::get();
        $this->data['allowances'] = Allowance::get();
    }

    public function get_allowance_details(Request $request)
    {
        // dd($request->id);
        $allowances = StaffAllowance::where('staff_id', $request->id)->get();
        $response = [];
        foreach ($allowances as $allowance) {
            $array = [
                'id' => $allowance->id,
                'amount' => $allowance->amount,
                'allowance' => $this->data['allowances']->where('id', $allowance->allowance)->pluck('name')->first(),
            ];

            array_push($response, $array);
        }

        echo json_encode($response);
    }
}
