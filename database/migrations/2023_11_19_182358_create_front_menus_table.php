<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFrontMenusTable extends Migration
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
        Schema::create($tableNames['front_menus'], function (Blueprint $table) use ($foreign_key) {
            $table->unsignedInteger('id', true);
            $table->integer('parent_id')->default(0);
            $table->string('title_hi', 150);
            $table->string('title_en', 150);
            $table->unsignedInteger($foreign_key['front_menu_types'])->nullable()->index();
            $table->unsignedInteger($foreign_key['acl_controller_routes'])->nullable()->index();
            $table->unsignedInteger($foreign_key['pages'])->nullable()->index();
            $table->boolean('open_same_tab')->default(0)->comment('0=same tab, 1=new tab');
            $table->integer('menu_order')->default('1');
            $table->string('class_id', 15)->nullable();
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
            $table->integer('menu_type')->default('1');
            $table->string('custom_url', 255)->nullable();
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });

        DB::statement("ALTER TABLE `tbl_front_menus` CHANGE `title_hi` `title_hi` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
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
        Schema::dropIfExists($tableNames['front_menus']);
    }
}
