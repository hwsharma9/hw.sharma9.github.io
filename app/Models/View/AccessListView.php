<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Model;

class AccessListView extends Model
{
    public function scopeFilter($query)
    {
        $filter = (array) request()->get('filter');
        $query->where(function ($query) use ($filter) {
            $query->when((isset($filter['title']) && !empty($filter['title'])), function ($query) use ($filter) {
                $query->where('title', 'like', '%' . $filter['title'] . '%');
            })
                ->when((isset($filter['resides_at']) && !empty($filter['resides_at'])), function ($query) use ($filter) {
                    $query->where('resides_at', $filter['resides_at']);
                })
                ->when((isset($filter['controller_name']) && !empty($filter['controller_name'])), function ($query) use ($filter) {
                    $query->where('controller_name', 'like', '%' . $filter['controller_name'] . '%');
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
