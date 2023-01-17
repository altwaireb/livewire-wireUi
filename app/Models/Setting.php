<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


class Setting extends Model
{
    use HasFactory;

    protected $fillable = [ 'key', 'display_name', 'value', 'type', 'order'];

    public function scopeSearch($query, $term)
    {
        $query->where(function ($query) use ($term) {
            $query->where('key', 'like', "%$term%")
                ->orWhere('display_name', 'like', "%$term%")
                ->orWhere('value', 'like', "%$term%");
        });
    }

    public static function getAllSettings()
    {
        return Cache::rememberForever('settings.all', function () {
            return self::all();
        });
    }

    /**
     * Get all the settings in array
     *
     * @return mixed
     */
    public static function getSettingsArray()
    {
        return Cache::rememberForever('settings.toArray', function () {
            return self::getAllSettings()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Check if setting exists
     *
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return (boolean)self::getAllSettings()->whereStrict('key', $key)->count();
    }

    /**
     * Get a settings value
     *
     * @param $key
     * @param null $default
     * @return bool|int|mixed
     */
    public static function get($key, $default = null)
    {
        if (self::has($key)) {
            $setting = self::getAllSettings()->where('key', $key)->first();
            return $setting->value;
        }
        return $default;
    }

    /**
     * Add a settings value
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public static function add($key, $value)
    {
        if (self::has($key)) {
            return self::set($key, $value);
        }
        return self::create(['key' => $key, 'value' => $value]) ? $value : false;
    }

    /**
     * Set a value for setting
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public static function set($key, $value)
    {
        if ($setting = self::getAllSettings()->where('key', $key)->first()) {
            return $setting->update([
                'key' => $key,
                'value' => $value]) ? $value : false;
        }
        return self::add($key, $value);
    }

    /**
     * Update Settings
     *
     * @param $data
     * @return void
     */
    public static function updateSettings($data)
    {
        foreach ($data as $key => $value) {
            self::set($key, $value);
        }
    }

    /**
     * Remove a setting
     *
     * @param $key
     * @return bool
     */
    public static function remove($key)
    {
        if (self::has($key)) {
            return self::where('key',$key)->delete();
        }

        return false;
    }

    /**
     * Flush the cache
     */
    public static function flushCache()
    {
        Cache::forget('settings.all');
        Cache::forget('settings.toArray');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            self::flushCache();
        });

        static::created(function () {
            self::flushCache();
        });

        static::deleted(function () {
            self::flushCache();
        });
    }

    public function getValueLimitAttribute(){
        if ($this->type === 'text' or $this->type === 'textarea'){
            return Str::words($this->value, 3, ' ...');
        }else{
            return $this->value;
        }
    }

}
