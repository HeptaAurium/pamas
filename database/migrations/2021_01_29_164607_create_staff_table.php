<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->integer('department_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('position')->nullable();
            $table->string('phone')->nullable();
            $table->string('secondarypno')->nullable();
            $table->string('email')->nullable();
            $table->string('secondaryemail');
            $table->string('tscno')->nullable();
            $table->string('basal')->nullable();
            $table->string('tax_groups')->nullable();
            $table->string('emergencypno')->nullable();
            $table->string('emergencyemail')->nullable();
            $table->string('location')->nullable();
            $table->string('estate')->nullable();
            $table->string('houseno')->nullable();
            $table->string('fileno')->nullable();
            $table->integer('active')->default(1);
            $table->integer('photo')->nullable();
            $table->integer('bank')->nullable();
            $table->integer('account_no')->nullable();
            $table->integer('secondary_acc')->nullable();
            $table->integer('secondary_bank')->nullable();

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
        $tg = [
            ['name' => 'PAYE'],
        ];

        DB::table('tax_groups')->insert($tg);
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
