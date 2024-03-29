<?php

namespace App\Models;

use App\Http\Traits\Encryptable;
use App\Http\Traits\Uploadable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use Uploadable;
    use Encryptable;

    protected $table = 'tbl_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'mobile',
        'fk_designation_id',
        'status',
        'email',
        'password',
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
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'name',
    ];

    // protected $guard = 'web';

    public function scopeFilter($query)
    {
        $query->where(function ($query) {
            $query->where('first_name', 'LIKE', '%' . request('first_name') . '%')
                ->orWhere('last_name', 'LIKE', '%' . request('last_name') . '%')
                ->orWhere('designation', 'LIKE', '%' . request('designation') . '%')
                ->orWhere('email', 'LIKE', '%' . request('email') . '%')
                ->orWhere('mobile', 'LIKE', '%' . request('mobile') . '%')
                ->orWhere('email', 'LIKE', '%' . request('email') . '%');
        });
    }

    public function getNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
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

    /**
     * Get the post's verificationCode.
     */
    public function verificationCode()
    {
        return $this->morphOne(VerificationCode::class, 'verifiable');
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
     * Get all of the enrolledCourses for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enroledCourses(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class, 'fk_user_id', 'id');
    }

    protected static function booted()
    {
        // Runs the script just after the admin model is created
        static::created(function ($user) {
            // set the username
            $user->username = self::createUsername($user);
            // and update the admin model
            $user->save();

            AdminRole::insert([
                'fk_user_id' => $user->id,
                'fk_role_id' => 5,
                'status' => 1,
                'is_default' => 1,
                'created_by' => 1,
                'created_at' => now(),
            ]);
            // Assign role to admin created above
            $user->assignRole(intval(5));
        });
    }
}
