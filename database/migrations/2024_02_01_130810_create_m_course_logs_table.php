<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_course_logs', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->unsignedInteger('fk_course_id')->index();
            $table->morphs('loggable');
            $table->string('remote_address', 100);
            $table->text('prev_data');
            $table->text('current_data');
            $table->boolean('course_status')->default(false);
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->dateTime('created_at')->nullable();
        });

        DB::statement("ALTER TABLE `m_course_logs` CHANGE `prev_data` `prev_data` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
        CHANGE `current_data` `current_data` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_course_logs');
    }
};
