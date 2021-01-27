<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role as Role;
use Spatie\Permission\Models\Permission;
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
       
     $role = Role::find(3);
     $permission= Permission::where('id', 5)->get();

     $role->syncPermissions($permission);
       
        return view('home', $this->data);
    }
}
