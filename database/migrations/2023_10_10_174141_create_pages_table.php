<?php

use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
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
        Schema::create($tableNames['pages'], function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->string('title_hi', 255);
            $table->text('description_hi');
            $table->string('title_en', 255);
            $table->text('description_en');
            $table->string('pre_url', 50)->default('page/content/');
            $table->string('slug', 100);
            $table->timestamp('added_date')->nullable();
            $table->string('added_by')->default(0);
            $table->timestamp('edit_date')->nullable();
            $table->string('edit_by')->default(0);
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_keyword', 200)->nullable();
            $table->string('meta_description', 200)->nullable();
            $table->boolean('is_default')->default(0);
            $table->boolean('is_on_homepage')->default(0);
            $table->string('banner', 200)->nullable();
            $table->boolean('is_sidebar')->default(0);
            $table->integer('sidebar_id');
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
        DB::statement("ALTER TABLE `" . $tableNames['pages'] . "` CHANGE `title_hi` `title_hi` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
        CHANGE `description_hi` `description_hi` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
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
        Schema::dropIfExists($tableNames['pages']);
    }
}
