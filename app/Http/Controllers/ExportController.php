<?php

namespace App\Http\Controllers;

use App\Http\Services\JsonService;
use App\Http\Services\MenuTree;
use App\Models\Admin;
use App\Models\AdminMenu;
use App\Models\AdminUserDetail;
use App\Models\CourseApprovalRequest;
use App\Models\FrontMenu;
use App\Notifications\Admin\RequestToApproveCourse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ExportController extends Controller
{
    public function exportTable($table)
    {
        $records = DB::table($table)->get();
        if ($records) {
            $columns = array_keys((array) $records[0]);
            // $columns = DB::getSchemaBuilder()->getColumnListing($table);
            $row_counter_stopper = request()->has('row_counter_stopper') ? request()->get('row_counter_stopper') : 500;
            $row_counter = 0;
            $query = '';
            $seeders = [];
            foreach ($records as $key => $record) {
                if ($row_counter == 0) {
                    $query .= 'insert into ' . $table . ' (' . implode(',', $columns) . ') values<br>';
                }
                $array = (array) $record;
                $query .= "(";
                $count = 1;
                $data_string = '';
                $row_data = [];
                foreach ($array as $name => $value) {
                    if (in_array($name, ['created_at', 'updated_at'])) {
                        $data_string .= "'" . date('Y-m-d H:i:s', strtotime($value)) . ((count($array) == $count) ? "'" : "',");
                        // $data_string .= "'" . date('Y-m-d H:i:s') . ((count($array) == $count) ? "'" : "',");
                        $row_data[$name] = "'" . date('Y-m-d H:i:s', strtotime($value)) . "'";
                    } else {
                        if (is_int($value)) {
                            $data_string .= $value . ((count($array) == $count) ? "" : ",");
                            $row_data[$name] = $value;
                        } else {
                            if ($value == "") {
                                $data_string .= 'NULL' . ((count($array) == $count) ? "" : ",");
                                $row_data[$name] = 'NULL';
                            } else {
                                $data_string .= "'" . addslashes($value) . ((count($array) == $count) ? "'" : "',");
                                $row_data[$name] = "'" . addslashes($value) . "'";
                            }
                        }
                    }
                    $count++;
                }
                // dd($columns, explode(',', $data_string), $row_data);
                $seeders[] = array_combine($columns, $row_data);
                $query .= $data_string;
                $query .= ($row_counter == ($row_counter_stopper - 1) || (count($records) == ($key + 1)) ? ");" : "),") . "<br>";
                $row_counter++;
                if ($row_counter == $row_counter_stopper) {
                    $row_counter = 0;
                }
            }
            echo "<pre>";
            // print_r($query);
            // echo "<br><br><br>";
            $seed_string = '';
            foreach ($seeders as $key => $seeds) {
                $seed_string .= "[<br>";
                $count = 0;
                foreach ($seeds as $key_name => $value) {
                    $seed_string .= "\t'" . $key_name . "'" . ' => ' . $value . (($count == count($seeds) - 1) ? "" : ", ") . '</br>';
                    if ($count == count($seeds)) {
                        $count = 0;
                    }
                    $count++;
                }
                $seed_string .= "],<br>";
            }
            echo $seed_string;
            echo "</pre>";
        }
    }

    public function tree()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('tbl_courses')->truncate();
        DB::table('tbl_course_approval_requests')->truncate();
        DB::table('tbl_course_media')->truncate();
        DB::table('tbl_course_topics')->truncate();
        DB::table('m_course_logs')->truncate();
        DB::table('notifications')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        dd('wait');
        // $admin = Admin::find(1);
        // $admin->fill([
        //     'email_verified_at' => now(),
        // ]);
        // $res1 = $admin->save();
        // $admin_detail = AdminUserDetail::where('fk_admin_id', 1)->first();
        // $admin_detail->fill([
        //     'employee_id' => rand(11111, 99999),
        // ]);
        // $res2 = $admin_detail->save();
        // dd($res1, $res2);
        Admin::where('status', 0)
            ->update([
                'email_verified_at' => now(),
                'mobile_verified_at' => now(),
                'password_changed_at' => now(),
                'is_profile_updated' => 1,
                'status' => 1
            ]);
        echo "<pre>";
        die('wait');
        // $menus_data = AdminMenu::without(['child'])
        //     ->with(['permission.dbControllerRoute.dbController'])
        //     ->orderBy('s_order', 'asc')
        //     ->get();
        // $menus = MenuTree::tree($menus_data, 0);
        // return $menus;
        // return $menu_data->pluck('permission.databaseRoutes.route');
    }
}
