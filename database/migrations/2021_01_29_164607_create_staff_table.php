<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('staff_unique_id')->unique();
            $table->string('national_id')->unique();
            $table->string('firstname');
            $table->string('middlename');
            $table->string('lastname');
            $table->integer('department_id');
            $table->integer('branch_id');
            $table->integer('position');
            $table->string('phone');
            $table->string('secondarypno');
            $table->string('email');
            $table->string('secondaryemail');
            $table->string('tscno')->nullable();
            $table->string('basal');
            $table->string('tax_groups');
            $table->string('emergencypno');
            $table->string('emergencyemail')->nullable();
            $table->string('location')->nullable();
            $table->string('estate')->nullable();
            $table->string('houseno')->nullable();
            $table->string('fileno')->nullable();
            $table->integer('active')->default(1);
            $table->integer('photo')->nullable();
            $table->integer('bank');
            $table->integer('account_no');
            $table->integer('secondary_acc');
            $table->integer('secondary_bank');

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            // $table->nullableTimestamps(0);
        });

        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('branch_head')->nullable();
            $table->string('department')->nullable();
            $table->timestamps();
        });

        Schema::create('staff_allowances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('staff_id');
            $table->string('allowance');
            $table->float('amount')->default(0);
            $table->timestamps();
        });
        Schema::create('staff_deductions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('staff_id');
            $table->string('deduction');
            $table->float('amount')->default(0);
            $table->timestamps();
        });
        Schema::create('staff_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('tax_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
