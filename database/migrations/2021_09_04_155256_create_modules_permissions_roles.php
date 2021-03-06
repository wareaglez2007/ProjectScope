<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesPermissionsRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules_permissions_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('roles_id');
            $table->foreign('roles_id')->references('id')->on('roles')
                ->onDelete('cascade');
            $table->unsignedBigInteger('modules_id');
            $table->foreign('modules_id')->references('id')->on('modules')
                ->onDelete('cascade');
            $table->unsignedBigInteger('permissions_id')->nullable();
            $table->foreign('permissions_id')->references('id')->on('permissions')
                ->onDelete('cascade');
            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->integer('assigned')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('modules_permissions_roles');
    }
}
