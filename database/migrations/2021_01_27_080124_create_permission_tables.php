<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });
        DB::table('permissions')->insert(
            array(
                'id' => 1,
                'name' => 'All',
                'guard_name' => 'Web',
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            )
        );
        DB::table('permissions')->insert(
            array(
                'id' => 2,
                'name' => 'Add Super-Admin',
                'guard_name' => 'Web',
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            )
        );
        DB::table('permissions')->insert(
            array(
                'id' => 3,
                'name' => 'Add Admin',
                'guard_name' => 'Web',
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            )
        );
        DB::table('permissions')->insert(
            array(
                'id' => 4,
                'name' => 'Add User',
                'guard_name' => 'Web',
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            )
        );
        DB::table('permissions')->insert(
            array(
                'id' => 5,
                'name' => 'Process Payroll',
                'guard_name' => 'Web',
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            )
        );
        DB::table('permissions')->insert(
            array(
                'id' => 6,
                'name' => 'Edit Settings',
                'guard_name' => 'Web',
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            )
        );
        DB::table('permissions')->insert(
            array(
                'id' => 7,
                'name' => 'Delete Staff',
                'guard_name' => 'Web',
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            )
        );

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
        });
        // Defaults
        DB::table('roles')->insert(
            array(
                'id' => 1,
                'name' => 'Super-Admin',
                'guard_name' => 'Web',
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            )
        );
        DB::table('roles')->insert(
            array(
                'id' => 2,
                'name' => 'Admin',
                'guard_name' => 'Web',
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            )
        );
        DB::table('roles')->insert(
            array(
                'id' => 3,
                'name' => 'Accountant',
                'guard_name' => 'Web',
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            )
        );
        DB::table('roles')->insert(
            array(
                'id' => 4,
                'name' => 'User',
                'guard_name' => 'Web',
                'created_at' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            )
        );


        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(
                ['permission_id', $columnNames['model_morph_key'], 'model_type'],
                'model_has_permissions_permission_model_type_primary'
            );
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(
                ['role_id', $columnNames['model_morph_key'], 'model_type'],
                'model_has_roles_role_model_type_primary'
            );
        });

        $mhr = [
            ['role_id' => 1, 'model_type' => 'App\Models\User', 'model_id' => 1],
            ['role_id' => 2, 'model_type' => 'App\Models\User', 'model_id' => 13],
            ['role_id' => 3, 'model_type' => 'App\Models\User', 'model_id' => 16],
            ['role_id' => 4, 'model_type' => 'App\Models\User', 'model_id' => 17],
        ];
        DB::table('model_has_roles')->insert($mhr);
        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        $rhp = [
            [
                'permission_id' => 1,
                'role_id' => 1,
            ], [
                'permission_id' => 2,
                'role_id' => 1,
            ], [
                'permission_id' => 3,
                'role_id' => 1,
            ], [
                'permission_id' => 3,
                'role_id' => 2,
            ], [
                'permission_id' => 4,
                'role_id' => 1,
            ], [
                'permission_id' => 4,
                'role_id' => 2,
            ], [
                'permission_id' => 5,
                'role_id' => 1,
            ], [
                'permission_id' => 5,
                'role_id' => 2,
            ], [
                'permission_id' => 5,
                'role_id' => 3,
            ], [
                'permission_id' => 6,
                'role_id' => 1,
            ], [
                'permission_id' => 6,
                'role_id' => 2,
            ], [
                'permission_id' => 7,
                'role_id' => 1,
            ], [
                'permission_id' => 7,
                'role_id' => 2,
            ],
        ];

        DB::table('role_has_permissions')->insert($rhp);
        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}
