<?php

namespace App\Traits;

use App\Models\UserPreference;

trait HasUserPreferences
{
    /**
     * Get a user preference by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getPreference(string $key, $default = null)
    {
        $preference = $this->preferences()->where('key', $key)->first();
        
        return $preference ? $preference->value : $default;
    }

    /**
     * Set a user preference.
     *
     * @param string $key
     * @param mixed $value
     * @return UserPreference
     */
    public function setPreference(string $key, $value)
    {
        $preference = $this->preferences()->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        return $preference;
    }

    /**
     * Remove a user preference.
     *
     * @param string $key
     * @return bool
     */
    public function removePreference(string $key)
    {
        return $this->preferences()->where('key', $key)->delete();
    }

    /**
     * Get all user preferences.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function preferences()
    {
        return $this->hasMany(UserPreference::class);
    }
}
