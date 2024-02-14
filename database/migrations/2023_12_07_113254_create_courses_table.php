<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_courses', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->unsignedInteger('fk_m_admin_course_id')->index();
            $table->text('description')->nullable();
            $table->text('update_description')->nullable();
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
            $table->boolean('is_edited')->default(true);
            $table->boolean('course_status')->default(false)->comment('0 => Draft, 1 => Submitted, 3 => Approved, 4 => Published');
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
        Schema::dropIfExists('tbl_courses');
    }
}
