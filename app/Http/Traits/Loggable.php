<?php

namespace App\Http\Traits;

use App\Models\MAdminLog;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

trait Loggable
{
    public static function createLog($old_model, Model $model)
    {
        // $old_model = Cache::pull('old_model');
        $new_model = clone $model;
        $new_model = $new_model->toArray();
        if (isset($old_model['created_at'])) {
            $old_model['created_at'] = date('Y-m-d H:i:s', strtotime($old_model['created_at']));
        }
        if (isset($old_model['updated_at'])) {
            $old_model['updated_at'] = date('Y-m-d H:i:s', strtotime($old_model['updated_at']));
        }
        if (isset($old_model['email_verified_at'])) {
            $old_model['email_verified_at'] = date('Y-m-d H:i:s', strtotime($old_model['email_verified_at']));
        }
        if (isset($old_model['mobile_verified_at'])) {
            $old_model['mobile_verified_at'] = date('Y-m-d H:i:s', strtotime($old_model['mobile_verified_at']));
        }
        if (isset($old_model['password_changed_at'])) {
            $old_model['password_changed_at'] = date('Y-m-d H:i:s', strtotime($old_model['password_changed_at']));
        }
        if (isset($new_model['created_at'])) {
            $new_model['created_at'] = date('Y-m-d H:i:s', strtotime($new_model['created_at']));
        }
        if (isset($new_model['updated_at'])) {
            $new_model['updated_at'] = date('Y-m-d H:i:s', strtotime($new_model['updated_at']));
        }
        if (isset($new_model['email_verified_at'])) {
            $new_model['email_verified_at'] = date('Y-m-d H:i:s', strtotime($new_model['email_verified_at']));
        }
        if (isset($new_model['mobile_verified_at'])) {
            $new_model['mobile_verified_at'] = date('Y-m-d H:i:s', strtotime($new_model['mobile_verified_at']));
        }
        if (isset($new_model['password_changed_at'])) {
            $new_model['password_changed_at'] = date('Y-m-d H:i:s', strtotime($new_model['password_changed_at']));
        }
        $model->logs()->create([
            'remote_address' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "127.0.0.1",
            'prev_data' => json_encode($old_model),
            'current_data' => json_encode($new_model),
            'created_at' => now(),
            'created_by' => auth('admin')->id(),
        ]);
    }

    public static function bootLoggable()
    {
        static::creating(function (Model $model) {
            // Log::info('Creating model: ');
            // Log::info($model);
            request()->session()->put('old_model', $model);
        });
        static::created(function (Model $model) {
            if (request()->session()->has('old_model')) {
                $old_model = request()->session()->get('old_model');
                // Log::info('Created model: old');
                // Log::info($old_model);
                // Log::info('Created model: new');
                // Log::info($model);
                self::createLog([], $model);
                request()->session()->forget('old_model');
            }
        });
        static::updating(function (Model $model) {
            // Log::info('Updating model: All');
            // Log::info($model);
            $original = $model->getOriginal();
            // Log::info('Updating model: getOriginal');
            // Log::info($original);
            if ($original) {
                // Log::info('Updating model: set_original');
                request()->session()->put('old_model', $original);
            } elseif ($model) {
                // Log::info('Updating model: set_all');
                request()->session()->put('old_model', $model);
            }
        });
        static::updated(function (Model $model) {
            if (request()->session()->has('old_model')) {
                $old_model = request()->session()->get('old_model');
                // Log::info('Updated model: old_model');
                // Log::info($old_model);
                // Log::info('Updated model: updated');
                // Log::info($model);
                // Log::info('----');
                // Log::info(($old_model == $model));
                // Log::info('++++');
                if (($old_model != $model)) {
                    self::createLog($old_model, $model);
                }
                request()->session()->forget('old_model');
            }
        });
    }

    /**
     * Get all of the post's logs.
     */
    public function logs()
    {
        return $this->morphMany(MAdminLog::class, 'loggable');
    }

    /**
     * Get the creator that owns the Media
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function logCreator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by')->select(['id', 'first_name', 'last_name', 'email', DB::raw('CONCAT(first_name, " ",last_name) as name')]);
    }
}
