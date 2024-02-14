<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAccessListView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW if exists access_list_views");
        DB::statement(
            "CREATE VIEW access_list_views AS
            SELECT AC.id, AC.title, AC.resides_at, AC.controller_name, 
            AC.status, 
            AC.created_at, 
            AC.updated_at, 
            AC.created_by, 
            AC.updated_by, 
            CONCAT(CR.first_name,' ', CR.last_name) AS creator_name, 
            CONCAT(ER.first_name,' ', ER.last_name) AS editor_name,
            ER.username AS editor_username,
            CR.username AS creator_username,
            CR.function_names 
            FROM `tbl_acl_controllers` AS AC 
            LEFT JOIN ( 
                SELECT GROUP_CONCAT(DISTINCT function_name) as function_names, 
                fk_controller_id 
                FROM tbl_acl_controller_routes AS ACR 
                LEFT JOIN tbl_acl_permissions AP 
                    ON ACR.id = AP.fk_controller_route_id 
                LEFT JOIN tbl_acl_role_has_permissions AS RHP 
                    ON AP.id = RHP.permission_id 
                GROUP BY fk_controller_id 
            ) AS CR 
            ON AC.id = CR.fk_controller_id
            LEFT JOIN tbl_admins AS CR ON AC.created_by = CR.id
            LEFT JOIN tbl_admins AS ER ON AC.updated_by = ER.id
            "
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW if exists access_list_views");
    }
}
