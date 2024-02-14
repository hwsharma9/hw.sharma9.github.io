<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMAdminLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_admin_logs', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->morphs('loggable');
            $table->string('remote_address', 100);
            $table->text('prev_data');
            $table->text('current_data');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->dateTime('created_at')->nullable();
        });

        DB::statement("ALTER TABLE `m_admin_logs` CHANGE `prev_data` `prev_data` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
        CHANGE `current_data` `current_data` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_admin_logs');
    }
}
