<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficeOnboardingsTable extends Migration
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
        Schema::create($tableNames['office_onboardings'], function (Blueprint $table) use ($foreign_key) {
            $table->unsignedInteger('id', true);
            $table->unsignedInteger($foreign_key['m_departments'])->index();
            $table->unsignedInteger($foreign_key['m_offices'])->index();
            $table->string('nodal_name', 255);
            $table->string('nodal_contact_number', 12);
            $table->string('nodal_email', 255);
            $table->string('office_address', 255);
            $table->unsignedInteger('created_by')->nullable()->index();
            $table->unsignedInteger('updated_by')->nullable()->index();
            $table->boolean('status')->default(false)->comment('0=Pending,1=Active,2=Inactive');
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
        Schema::dropIfExists($tableNames['office_onboardings']);
    }
}
