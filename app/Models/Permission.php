<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'key', 'table_name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function scopeSearch($query, $term)
    {
        $query->where(function ($query) use ($term) {
            $query->where('name', 'like', "%$term%")
                ->orWhere('key', 'like', "%$term%")
                ->orWhere('table_name', 'like', "%$term%");
        });
    }

    /**
     * Generate Permissions by use table name
     *
     * @param $table_name
     */

    public static function generateFor($table_name)
    {
        self::firstOrCreate(['name' => 'viewAny ' . $table_name, 'key' => 'viewAny_' . $table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['name' => 'view ' . $table_name, 'key' => 'view_' . $table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['name' => 'update ' . $table_name, 'key' => 'update_' . $table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['name' => 'create ' . $table_name, 'key' => 'create_' . $table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['name' => 'delete ' . $table_name, 'key' => 'delete_' . $table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['name' => 'restore ' . $table_name, 'key' => 'restore_' . $table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['name' => 'force delete ' . $table_name, 'key' => 'forceDelete_' . $table_name, 'table_name' => $table_name]);
    }

    /**
     * remove Permissions by use table name
     *
     * @param $table_name
     */

    public static function removeFrom($table_name)
    {
        self::where(['table_name' => $table_name])->delete();
    }

}
