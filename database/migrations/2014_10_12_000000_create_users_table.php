<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->string('username', 100)->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('mobile', 10)->nullable();
            $table->string('email', 100)->unique();
            $table->unsignedInteger('fk_designation_id')->nullable()->index();
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('tbl_users');
    }
};
