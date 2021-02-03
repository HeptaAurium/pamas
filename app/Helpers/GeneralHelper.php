<?php

namespace App\Helpers;

use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Filesystem\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class GeneralHelper
{
    static function userOnlineStatus()
    {
        $users = User::all();
        foreach ($users as $user) {
            if (Cache::has('user-is-online-' . $user->id))
                echo $user->name . " is online. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
            else
                echo $user->name . " is offline. Last seen: " . Carbon::parse($user->last_seen)->diffForHumans() . " <br>";
        }
    }

    static function get_user_name($id)
    {
        return User::where('id', $id)->pluck('name')->first();
    }

    static function add_allowance($id)
    { //Set the amount for this new allowance to zero for all registered staff members;
        $staff = Staff::get();
        try {
            foreach ($staff as $item) {
                DB::table('staff_allowances')->insert([
                    'staff_id' => $item->id,
                    'allowance' => $id,
                    'amount' => 0,
                    'created_at' => Date('Y-m-d H:i:s'),
                    'updated_at' => Date('Y-m-d H:i:s'),
                ]);
            }
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            \Log::error($th);
            return false;
        }
    }
    static function add_deduction($id)
    { //Set the amount for this new deduction to zero for all registered staff members;
        $staff = Staff::get();
        try {
            foreach ($staff as $item) {
                DB::table('staff_deductions')->insert([
                    'staff_id' => $item->id,
                    'deduction' => $id,
                    'amount' => 0,
                    'created_at' => Date('Y-m-d H:i:s'),
                    'updated_at' => Date('Y-m-d H:i:s'),
                ]);
            }
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            \Log::error($th);
            return false;
        }
    }

    // Compute Totals


}
