<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_offices', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->unsignedInteger('fk_department_id')->index();
            $table->string('title_en', 150);
            $table->string('title_hi', 150);
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `m_offices` CHANGE `title_en` `title_en` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `title_hi` `title_hi` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_offices');
    }
}
