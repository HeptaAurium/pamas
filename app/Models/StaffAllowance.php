<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAllowance extends Model
{
    use HasFactory;

    protected $table = 'staff_allowances';

    protected $fillable = ['allowance', 'staff_id', 'amount'];
}
