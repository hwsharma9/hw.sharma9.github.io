<?php

namespace App\Http\Traits;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait Admined
{
    public static function bootAdmined()
    {
        // parent::boot();

        self::creating(function ($model) {
            $model->created_by = auth()->id();
            $model->updated_by = null;
            if (!$model->updated_at) {
                $model->updated_at = null;
            }
        });

        self::updating(function ($model) {
            $updates = [];
            if (!$model->updated_by) {
                $updates['updated_by'] = auth()->id();
            }
            if (!$model->updated_at) {
                $updates['updated_at'] = now();
            }
            Log::info('updating the info from admined');
            $model->fill($updates);
        });
    }

    /**
     * Get the creator that owns the Media
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by')->select(['id', 'first_name', 'last_name', 'username']);
    }

    /**
     * Get the editor that owns the Media
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by')->select(['id', 'first_name', 'last_name', 'username']);
    }
}
