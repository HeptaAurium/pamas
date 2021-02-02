<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('staff_id');
            $table->float('basal');
            $table->float('gross_pay');
            $table->float('net_pay');
            $table->float('total_additions');
            $table->float('total_deductions');
            $table->float('tax');
            $table->integer('bank');
            $table->string('account_no');
            $table->string('month');
            $table->string('year');
            $table->timestamps();
        });

      
        Schema::create('deductions', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        DB::update("ALTER TABLE deductions AUTO_INCREMENT = 9500;");

        Schema::create('allowances', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name');
            $table->timestamps();
        }); 

        DB::update("ALTER TABLE allowances AUTO_INCREMENT = 9500;");

        
        Schema::create('banks', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name');
            $table->integer('is_primary')->default(0);
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
        Schema::dropIfExists('payrolls');
    }
}
