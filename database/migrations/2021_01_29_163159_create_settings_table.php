<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('multi_branch');
            $table->string('business_logo')->nullable();
            $table->integer('allowance_grouping');
            $table->integer('deductions_grouping');
            $table->integer('has_primary_bank');
            $table->integer('tax_relief');
            $table->timestamps();
        });

        DB::table('settings')->insert(
            array(
                'id' => 1,
                'business_name'=>"iChael's P@Mas",
                'multi_branch' => 1,
                'business_logo'=>NULL,
                'allowance_grouping'=>0,
                'deductions_grouping'=>0,
                'has_primary_bank'=>1,
                'tax_relief'=>1280,
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
