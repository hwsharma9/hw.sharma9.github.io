<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('dbtables.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/dbtables.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['slider_categories'], function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->string('cat_title_en', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('dbtables.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/dbtables.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::dropIfExists($tableNames['slider_categories']);
    }
}
