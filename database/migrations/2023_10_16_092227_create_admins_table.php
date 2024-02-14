<?php

use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
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

        Schema::create($tableNames['admins'], function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            // $table->integer('parent_id')->default(0)->index();
            // $table->integer('fk_office_onboarding_id')->nullable()->index();
            $table->string('username', 100)->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('mobile', 10)->nullable();
            $table->string('email', 100)->unique();
            // $table->string('employee_id', 100)->nullable();
            $table->unsignedInteger('fk_designation_id')->nullable()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('password_changed_at')->nullable()->comment('NULL => not changed, date => changed');
            $table->rememberToken();
            $table->boolean('is_profile_updated')->default(false);
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
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

        Schema::dropIfExists($tableNames['admins']);
    }
}
