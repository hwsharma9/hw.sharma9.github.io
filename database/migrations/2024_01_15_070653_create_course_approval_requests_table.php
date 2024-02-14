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
        Schema::create('tbl_course_approval_requests', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->unsignedInteger('fk_course_id')->index();
            $table->text('remark')->nullable();
            $table->string('topic_ids')->nullable();
            $table->boolean('status')->default(false)->comment('0=Submitted for Approval,1=Send for correction, 2 => Approved');
            $table->char('fk_notification_id', 36)->nullable();
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
        Schema::dropIfExists('tbl_course_approval_requests');
    }
};
