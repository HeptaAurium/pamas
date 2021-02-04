<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Staff extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "staff";

    protected $fillable = [
        "firstname", "middlename", "lastname", "phone", "secondarypno", "email", "secondaryemail", "emergencypno", "emergencyemail", "location", "estate", "houseno", "staff_unique_id", "national_id", "branch_id", "department_id", "position", "tscno", "basal", "tax_groups", "fileno", "bank", "account_no", "secondary_acc", "secondary_bank","gender", "dob"
    ];

    static function insertData($data)
    {
        // $data->validate([
        //     'staff_unique_id' => 'bail|required|unique:staff,staff_unique_id',
        //     'national_id' => 'bail|required|unique:staff,national_id',
        //     'tscno' => 'bail|sometimes|unique:staff,tscno',
        // ]);

        // $value = DB::table('test')->where('username', $data['username'])->get();
        // if ($value->count() == 0) {
        //     DB::table('test')->insert($data);
        // }

        DB::table('staff')->insert($data);
    }

    public function getTableColumns() {
        return $this
            ->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($this->getTable());
    }
}
