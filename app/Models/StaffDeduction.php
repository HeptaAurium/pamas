<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffDeduction extends Model
{
    use HasFactory;

    
    protected $table = 'staff_deductions';

    protected $fillable = ['allowance', 'staff_id', 'amount'];
}
