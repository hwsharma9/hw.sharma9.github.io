<?php

use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignUserAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $dbtables = config('dbtables.table_names');
        $foreign_key = config('dbtables.foreign_key');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        if (empty($dbtables)) {
            throw new \Exception('Error: config/dbtables.php not loaded. Run [php artisan config:clear] and try again.');
        }
        Schema::create($dbtables['assign_user_accesses'], function (Blueprint $table) use ($tableNames, $foreign_key) {
            $table->unsignedInteger('id', true);
            $table->unsignedInteger($foreign_key['roles'])->index();
            $table->unsignedInteger('fk_controller_id')->index();
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->unique([$foreign_key['roles'], 'fk_controller_id'], 'unique_role_controller');

            // $table->foreign($foreign_key['roles'])->references('id')->on($tableNames['roles']);
            // $table->foreign('fk_controller_id')->references('id')->on('tbl_acl_controllers');
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
        Schema::dropIfExists('tbl_assign_user_accesses');
    }
}
