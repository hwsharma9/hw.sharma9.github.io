<?php

use App\Models\SliderCategory;
use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('dbtables.table_names');
        $foreign_key = config('dbtables.foreign_key');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/dbtables.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['sliders'], function (Blueprint $table) use ($tableNames, $foreign_key) {
            $table->unsignedInteger('id', true);
            $table->string('title_hi');
            $table->string('title_en');
            $table->unsignedInteger($foreign_key['slider_categories']);
            $table->unsignedInteger($foreign_key['acl_controller_routes'])->nullable()->index();
            $table->unsignedInteger($foreign_key['pages'])->nullable()->index();
            $table->string('custom_url', 255)->nullable();
            $table->integer('menu_type')->default('1');
            $table->boolean('order_preference')->default(1);
            // $table->timestamp('published_at');
            $table->boolean('status')->default(true)->comment('0=Pending,1=Active,2=Inactive');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->foreign($foreign_key['slider_categories'])->references('id')->on($tableNames['slider_categories']);
        });
        DB::statement("ALTER TABLE `" . $tableNames['sliders'] . "` CHANGE `title_hi` `title_hi` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
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

        Schema::dropIfExists($tableNames['sliders']);
    }
}
