<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'key' , 'color'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Check if Role has Permission
     *
     * @param $key
     * @return bool
     */
    public function hasPermission($key)
    {
        return $this->permissions()->where('key', $key)->exists();
    }

    public function scopeSearch($query, $term){
        $query->where(function ($query) use ($term){
            $query->where('name','like', "%$term%")
                ->orWhere('key','like', "%$term%")
                ->orWhere('color','like', "%$term%");
        });
    }

}
