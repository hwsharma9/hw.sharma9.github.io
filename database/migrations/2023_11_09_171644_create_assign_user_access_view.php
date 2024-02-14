<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAssignUserAccessView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("DROP VIEW if exists assign_user_access_views");
        DB::statement("
        CREATE VIEW assign_user_access_views AS
        SELECT AUA.id,
        AUA.fk_role_id,
        R.name AS role_name,
        IQ1.fk_controller_id,
        AC.title,
        AC.controller_name,
        IQ1.function_name,
        AUA.status,
        AUA.created_at, 
        AUA.updated_at, 
        AUA.created_by,
        AUA.updated_by,
        CONCAT(CR.first_name,' ', CR.last_name) AS creator_name, 
        CONCAT(ER.first_name,' ', ER.last_name) AS editor_name,
        ER.username AS editor_username,
        CR.username AS creator_username
            FROM `tbl_assign_user_accesses` AS AUA 
            LEFT JOIN tbl_acl_roles AS R 
                ON AUA.fk_role_id = R.id
            LEFT JOIN tbl_admins AS CR ON AUA.created_by = CR.id
            LEFT JOIN tbl_admins AS ER ON AUA.updated_by = ER.id
            LEFT JOIN tbl_acl_controllers AS AC 
                ON AUA.fk_controller_id = AC.id
            LEFT JOIN (
                SELECT ACR.fk_controller_id, 
                GROUP_CONCAT(DISTINCT ACR.function_name) AS function_name, 
                RHP.role_id 
                FROM tbl_acl_controller_routes AS ACR
                LEFT JOIN tbl_acl_permissions AS P 
                    ON ACR.id = P.fk_controller_route_id
                LEFT JOIN tbl_acl_role_has_permissions RHP 
                    ON P.id = RHP.permission_id
                GROUP BY ACR.fk_controller_id, RHP.role_id
                ORDER BY ACR.fk_controller_id DESC
            ) AS IQ1 ON AUA.fk_controller_id = IQ1.fk_controller_id 
            AND AUA.fk_role_id = IQ1.role_id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW if exists assign_user_access_views");
    }
}
