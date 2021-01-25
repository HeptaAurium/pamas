<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{


    public function __construct()
    {
        global $data;
        $this->data = &$data;

        $this->data['settings'] = SystemSetting::find(1);
        $this->data['tax_groups'] = DB::table('tax_groups')->get();
        $this->data['departments'] = DB::table('departments')->get();
        $this->data['branches'] = DB::table('branches')->get();
        $this->data['position'] = DB::table('staff_positions')->get();
        $this->data['users'] = User::get();
        $this->data['staff'] = Staff::get();
    }

    public function index()
    {
        return view('home', $this->data);
    }
}
