<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpLinksTable extends Migration
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
        Schema::create($tableNames['imp_links'], function (Blueprint $table) use ($foreign_key) {
            $table->unsignedInteger('id', true);
            $table->string('title_hi', 150);
            $table->string('title_en', 150);
            $table->integer('menu_type')->default('1');
            $table->unsignedInteger($foreign_key['acl_controller_routes'])->nullable()->index();
            $table->unsignedInteger($foreign_key['pages'])->nullable()->index();
            $table->string('custom_url', 255)->nullable();
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
        DB::statement("ALTER TABLE `tbl_imp_links` CHANGE `title_hi` `title_hi` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, CHANGE `title_en` `title_en` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
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
        Schema::dropIfExists($tableNames['imp_links']);
    }
}
