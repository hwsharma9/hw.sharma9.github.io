<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_admin_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('actual_admin_user_id')->comment('Previous user from charge taken')->nullable()->index();
            $table->unsignedInteger('fk_user_id')->comment('Additional Charge to given')->index();
            $table->unsignedInteger('fk_role_id')->comment('Additional Role given to user')->index();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('remark', 250)->nullable();
            $table->boolean('is_default')->default(false)->comment('1=Default Role, 0=>Additional Role');
            $table->unsignedInteger('fk_reason_id')->nullable()->index();
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_admin_roles');
    }
}
