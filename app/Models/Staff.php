<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "staff";

    protected $fillable = [
        "firstname", "middlename ", "lastname", "phone", "secondarypno", "email", "secondaryemail", "emergencypno", "emergencyemail", "location", "estate", "houseno", "staff_unique_id", "national_id", "branch_id", "department_id","position", "tscno", "basal", "tax_groups", "fileno", "bank", "account_no", "secondary_acc", "secondary_bank",
    ];
}
