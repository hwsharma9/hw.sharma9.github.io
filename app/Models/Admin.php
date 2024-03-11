<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Encryptable;
use App\Http\Traits\HasStatus;
use App\Http\Traits\Loggable;
use App\Http\Traits\Uploadable;
use App\Notifications\Admin\ResetPassword;
use App\Notifications\Admin\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use Admined;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use Loggable;
    use Uploadable;
    use Encryptable;
    use HasStatus;

    protected $table = 'tbl_admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'fk_office_onboarding_id',
        'username',
        'first_name',
        'last_name',
        'mobile',
        'fk_designation_id',
        'status',
        'email',
        'password',
        'email_verified_at',
        'mobile_verified_at',
        'password_changed_at',
        'is_profile_updated',
        'password_changed_at',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'created_at' => 'datetime:d-m-Y H:i:s',
        // 'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'name',
        'master_name'
    ];

    /**
     * Auto hash password when create/update
     *
     * @param $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    /**
     * Send the password reset link notification.
     *
     * @param $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

    public function getNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getMasterNameAttribute()
    {
        return $this->name . " (" . $this->username . ")";
    }

    /**
     * Get the post's verificationCode.
     */
    public function verificationCode()
    {
        return $this->morphOne(VerificationCode::class, 'verifiable');
    }

    public function hasActiveVerificationCode()
    {
        return $this->verificationCode()->active()->latest('id')->first();
    }

    /**
     * Get the designation that owns the Admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function designation(): BelongsTo
    {
        return $this->belongsTo(MDesignation::class, 'fk_designation_id', 'id');
    }

    /**
     * Get all of the admin_roles for the Admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function admin_roles(): HasMany
    {
        return $this->hasMany(AdminRole::class, 'fk_user_id', 'id');
    }


    /**
     * Get the detail associated with the Admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function detail(): HasOne
    {
        return $this->hasOne(AdminUserDetail::class, 'fk_admin_id', 'id');
    }

    /**
     * Get all of the assignCourses for the Admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assignCourses(): HasMany
    {
        return $this->hasMany(MAdminCourse::class, 'fk_admin_id', 'id');
    }

    /**
     * Check if username is valid or not
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public static function createUsername($user)
    {
        $username = 'LMS' . str_pad($user->id, 5, "0", STR_PAD_LEFT) . generateRandomString('4', '123456789') . date('my');
        if (self::where('username', $username)->exists()) {
            return self::createUsername($user);
        }
        return $username;
    }

    protected static function booted()
    {
        // Runs the script just after the admin model is created
        static::created(function ($user) {
            // set the username
            $user->username = self::createUsername($user);
            // and update the admin model
            $user->save();
        });
    }

    public function scopeFilter($query)
    {
        $filter = (array) request()->get('filter');
        $query->where(function ($query) use ($filter) {
            $query->when((isset($filter['name']) && !empty($filter['name'])), function ($query) use ($filter) {
                $query->where('first_name', 'like', '%' . $filter['name'] . '%')
                    ->orWhere('last_name', 'like', '%' . $filter['name'] . '%');
            })
                ->when((isset($filter['email']) && !empty($filter['email'])), function ($query) use ($filter) {
                    $query->where('email', 'like', '%' . $filter['email'] . '%');
                })
                ->when((isset($filter['mobile']) && !empty($filter['mobile'])), function ($query) use ($filter) {
                    $query->where('mobile', 'like', '%' . $filter['mobile'] . '%');
                })
                ->when((isset($filter['username']) && !empty($filter['username'])), function ($query) use ($filter) {
                    $query->where('username', 'like', '%' . $filter['username'] . '%');
                })
                ->when((isset($filter['status'])), function ($query) use ($filter) {
                    $query->where('status', $filter['status']);
                })
                ->when((isset($filter['role_id']) && !empty($filter['role_id'])), function ($query) use ($filter) {
                    $query->whereHas('roles', function ($query) use ($filter) {
                        $query->where('id', $filter['role_id']);
                    });
                })
                ->when((isset($filter['office_id']) && !empty($filter['office_id'])), function ($query) use ($filter) {
                    $query->whereHas('detail', function ($query) use ($filter) {
                        $query->where('fk_office_onboarding_id', $filter['office_id']);
                    });
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
