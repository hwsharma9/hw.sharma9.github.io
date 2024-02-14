<?php

use App\Models\Permission;
use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminMenusTable extends Migration
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
        Schema::create($tableNames['admin_menus'], function (Blueprint $table) use ($foreign_key) {
            $table->unsignedInteger('id', true);
            $table->string('menu_name', 40)->nullable();
            $table->string('icon_class', 50)->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('s_order')->nullable();
            $table->string('class_id', 15)->nullable();
            $table->text('params')->nullable();
            $table->unsignedInteger($foreign_key['permissions'], false)->nullable()->index();
            $table->tinyInteger('tab_same_new')->default(1)->comment("1 for same, 2 fro new");
            $table->tinyInteger('is_active')->default(1);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            // $table->foreign($foreign_key['permissions'])->references('id')->on('tbl_acl_permissions');
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
        Schema::dropIfExists($tableNames['admin_menus']);
    }
}
