<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'key', 'color', 'default'];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'default' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Check if Role has Permission
     *
     * @param $key
     * @return bool
     */
    public function hasPermission($key): bool
    {
        return $this->permissions()->where('key', $key)->exists();
    }

    public function scopeSearch($query, $term)
    {
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', "%$term%")
                ->orWhere('key', 'like', "%$term%")
                ->orWhere('color', 'like', "%$term%");
        });
    }

    /**
     * Get ID Role if column default
     * value is True
     */
    public static function default()
    {
        $data = self::where('default',1)->first();
        if (!empty($data)){
            return $data->id;
        }
        return null;
    }

}
