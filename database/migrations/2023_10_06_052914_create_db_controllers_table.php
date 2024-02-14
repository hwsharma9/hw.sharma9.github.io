<?php

use App\Models\DbController;
use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDbControllersTable extends Migration
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

        Schema::create('tbl_acl_controllers', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->string('title');
            $table->string('resides_at')->default('manage')->nullable();
            $table->string('controller_name');
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
        Schema::create('tbl_acl_controller_routes', function (Blueprint $table) use ($tableNames, $foreign_key) {
            $table->unsignedInteger('id', true);
            $table->string('route');
            $table->string('named_route');
            $table->string('method');
            $table->string('function_name');
            $table->unsignedInteger('fk_controller_id')->index();
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->foreign('fk_controller_id')->references('id')->on('tbl_acl_controllers');
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

        Schema::dropIfExists('tbl_acl_controller_routes');
        Schema::dropIfExists('tbl_acl_controllers');
    }
}
