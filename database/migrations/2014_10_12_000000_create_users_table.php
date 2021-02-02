<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('last_login')->nullable();
            $table->string('online')->default(0);
            $table->integer('active')->default(1);
            $table->integer('deleted_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        DB::table('users')->insert(
            array(
                'id' => 1,
                'name' => 'Admin Default',
                'email' => 'admin@pamas.ichaelinc.co.ke',
                'password' => Hash::make('admin@pamas'),
            )
        );
        DB::table('users')->insert(
            array(
                'id' => 2,
                'name' => 'User Default',
                'email' => 'user@pamas.ichaelinc.co.ke',
                'password' => Hash::make('user@pamas'),
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
        Schema::dropIfExists('users');
    }
}
