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
        Schema::create('tbl_course_configurations', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->unsignedInteger('fk_course_category_id')->index();
            $table->unsignedInteger('fk_course_category_courses_id')->index();
            $table->boolean('is_upload_pdf')->default(false)->comment('if 1 then course contains PDF else not');
            $table->boolean('is_upload_video')->default(false)->comment('if 1 then course contains Video else not');
            $table->boolean('is_upload_ppt')->default(false)->comment('if 1 then course contains PPT else not');
            $table->boolean('is_upload_doc')->default(false)->comment('if 1 then course contains DOC else not');
            $table->boolean('is_upload_pdf_required')->default(false);
            $table->boolean('is_upload_video_required')->default(false);
            $table->boolean('is_upload_ppt_required')->default(false);
            $table->boolean('is_upload_doc_required')->default(false);
            $table->boolean('is_enrolment_required')->default(true)->comment('1 => enrolment required, 0 => No');
            $table->boolean('is_visible')->default(false)->comment('0=Not Visible, 1=Visible');
            $table->date('active_from')->nullable();
            $table->date('active_to')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_downloadable')->default(false);
            $table->boolean('is_course_completion_trackable')->default(false);
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
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
        Schema::dropIfExists('tbl_course_configurations');
    }
};
