<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePayeConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paye_configs', function (Blueprint $table) {
            $table->id();
            $table->integer('minimum_taxable_income');
            $table->integer('maximum_taxable_income');
            $table->integer('tax_relief');
            $table->integer('step');
            $table->enum('timeline', ['monthly', 'yearly']);
            $table->timestamps();
        });

        DB::table('paye_configs')
            ->insert([
                'minimum_taxable_income' => 2400,
                'maximum_taxable_income' => 32334,
                'tax_relief' => 2400,
                'step' => 8333,
                'timeline' => 'monthly',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        Schema::create('paye_rates', function (Blueprint $table) {
            $table->id();
            $table->integer('min');
            $table->integer('max');
            $table->float('rate');
            $table->timestamps();
        });

        DB::table('paye_rates')
            ->insert([
                ['min' => 0, 'max' => 24000, 'rate' => 10, 'created_at' => now(), 'updated_at' => now()],
                ['min' => 24001, 'max' => 32333, 'rate' => 25, 'created_at' => now(), 'updated_at' => now()],
                ['min' => 32334, 'max' => 99999999, 'rate' => 30, 'created_at' => now(), 'updated_at' => now()]
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paye_configs');
    }
}
