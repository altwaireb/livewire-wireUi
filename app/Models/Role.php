<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function users()
    {
        return $this->hasMany(User::class)->withTrashed();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Check if Role has Permission
     *
     */
    public function hasPermission($key)
    {
        if (! $this->permissions) {
            return false;
        }
        return $this->permissions()->where('key',$key)->exists();
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
     * Get Role if column default
     * value is True
     */
    public static function default()
    {
        $data = self::where('default',1)->first();
        if (!empty($data)){
            return $data;
        }
        return null;
    }

    /**
     * Get Column ID Role if column default true
     * value is True
     */
    public static function getDefaultBy($column = 'id'){

        return self::default() != null ? self::default()->$column : null;
    }

}
