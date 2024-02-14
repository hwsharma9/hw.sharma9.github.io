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
        Schema::create('tbl_course_media', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->morphs('uploadable');
            $table->unsignedInteger('fk_course_id')->index();
            $table->string('file_mime_type');
            $table->string('file_path', 500)->nullable();
            $table->string('update_file_path', 500)->nullable();
            $table->string('original_name', 255);
            $table->string('field_name', 255)->nullable();
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
            $table->boolean('course_status')->default(false)->comment('0 => Draft, 1 => Submitted, 3 => Approved, 4 => Published');
            $table->softDeletes();
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
        Schema::dropIfExists('tbl_course_media');
    }
};
