<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'role_id',
        'last_activity',
        'profile_photo_path'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
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
        'profile_photo_url',
    ];



    public function role()
    {
        return $this->belongsTo(Role::class)->withTrashed();
    }


    public function hasPermission($key)
    {
        if (! $this->role) {
            return false;
        }
        return $this->role->permissions()->where('key',$key)->exists();
    }

    public function scopeSearch($query, $term)
    {
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', "%$term%")
                ->orWhere('email', 'like', "%$term%")
                ->orWhere('id', 'like', "%$term%");
        });
    }

    public function scopeUpdateLastActivity(): void
    {
        $this->timestamps = false;
        $this->update([
            'last_activity'=> now(),
        ]);
    }

    public function isOnline(): bool
    {
        return Cache::has('user-is-online' .$this->id);
    }

    public function getLastActivityForHumansAttribute()
    {
        if ($this->last_activity != null){
            return Carbon::parse($this->last_activity)->diffForHumans();
        }
        return $this->last_activity;

    }


}
