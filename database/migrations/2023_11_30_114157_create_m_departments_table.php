<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_departments', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->string('title_hi', 150);
            $table->string('title_en', 150);
            $table->boolean('status')->default(true)->comment('0=Pending,1=Active,2=Inactive');
            $table->softDeletes();
        });
        // DB::statement("ALTER TABLE `m_departments` CHANGE `title_hi` `title_hi` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_departments');
    }
}
