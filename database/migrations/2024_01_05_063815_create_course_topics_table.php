<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_course_topics', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->unsignedInteger('fk_course_id')->index();
            $table->string('title', 255)->nullable();
            $table->string('update_title', 255)->nullable();
            $table->text('summary')->nullable();
            $table->text('update_summary')->nullable();
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
            $table->boolean('is_edited')->default(false);
            $table->boolean('course_status')->default(false)->comment('0 => Draft, 1 => Submitted, 3 => Approved, 4 => Published');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_course_topics');
    }
};
