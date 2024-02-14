<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Model;

class AssignUserAccessView extends Model
{
    public function scopeFilter($query)
    {
        $filter = (array) request()->get('filter');
        $query->where(function ($query) use ($filter) {
            $query->when((isset($filter['title']) && !empty($filter['title'])), function ($query) use ($filter) {
                $query->where('title', 'like', '%' . $filter['title'] . '%');
            })
                ->when((isset($filter['fk_role_id']) && !empty($filter['fk_role_id'])), function ($query) use ($filter) {
                    $query->where('fk_role_id', $filter['fk_role_id']);
                })
                ->when((isset($filter['fk_controller_id']) && !empty($filter['fk_controller_id'])), function ($query) use ($filter) {
                    $query->where('fk_controller_id', $filter['fk_controller_id']);
                })
                ->when((isset($filter['status'])), function ($query) use ($filter) {
                    $query->where('status', $filter['status']);
                })
                ->when((isset($filter['created_at']) && !empty($filter['created_at'])), function ($query) use ($filter) {
                    $created_at = explode(" - ", $filter['created_at']);
                    $startDate = $created_at[0];
                    $endDate = $created_at[1];
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                })
                ->when((isset($filter['updated_at']) && !empty($filter['updated_at'])), function ($query) use ($filter) {
                    $updated_at = explode(" - ", $filter['updated_at']);
                    $startDate = $updated_at[0];
                    $endDate = $updated_at[1];
                    $query->whereBetween('updated_at', [$startDate, $endDate]);
                });
        });
    }
}
