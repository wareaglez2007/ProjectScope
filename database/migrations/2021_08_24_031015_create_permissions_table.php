<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /**
         * Permissions table
         * Needs:
         * 1. ID
         * 2. access_type
         * 3. access_rights
         * 4. created_date
         * 5. updated_date
         * 6. created_by (user id)
         **/
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('access_type')->uniqid();
            $table->bigInteger('access_rights')->unique();
            $table->string('created_by')->default('PermissionsSeeder');
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
        Schema::dropIfExists('permissions');
    }
}
