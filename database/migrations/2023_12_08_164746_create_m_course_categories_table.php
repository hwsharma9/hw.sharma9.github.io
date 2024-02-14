<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMCourseCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_course_categories', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->unsignedInteger('fk_department_id')->index();
            $table->string('category_name_hi');
            $table->string('category_name_en');
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
        DB::statement("ALTER TABLE `m_course_categories` CHANGE `category_name_hi` `category_name_hi` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `category_name_en` `category_name_en` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_course_categories');
    }
}
