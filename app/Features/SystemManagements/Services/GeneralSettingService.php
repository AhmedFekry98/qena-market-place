<?php

namespace App\Features\SystemManagements\Services;

use App\Features\SystemManagements\Models\GeneralSetting;
use Exception;

class GeneralSettingService
{
    protected static $model = GeneralSetting::class;

    /**
     * Get all settings with optional search and pagination
     */
    public static function getAllSettings()
    {
        try {
            $search = request()->get('search');
            $paginated = request()->boolean('page');
            $query = self::$model::query();

            if ($search) {
                $query->where('key', 'like', "%{$search}%")
                      ->orWhere('value', 'like', "%{$search}%");
            }

            return $paginated ? $query->paginate(config('paginate.count')) : $query->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get setting by ID
     */
    public static function getSettingById($id)
    {
        try {
            $setting = self::$model::find($id);

            if (!$setting) {
                return 'Setting not found';
            }

            return $setting;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get setting by key
     */
    public static function getSettingByKey($key)
    {
        try {
            $setting = self::$model::where('key', $key)->first();

            if (!$setting) {
                return 'Setting not found';
            }

            return $setting;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Create new setting
     */
    public static function createSetting($data)
    {
        try {
            // Check if key already exists
            $existingSetting = self::$model::where('key', $data['key'])->first();
            if ($existingSetting) {
                return 'Setting with this key already exists';
            }

            return self::$model::create($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update setting by ID
     */
    public static function updateSettingById($id, $data)
    {
        try {
            $setting = self::$model::find($id);

            if (!$setting) {
                return 'Setting not found';
            }

            // Check if key already exists (excluding current setting)
            if (isset($data['key'])) {
                $existingSetting = self::$model::where('key', $data['key'])
                                                ->where('id', '!=', $id)
                                                ->first();
                if ($existingSetting) {
                    return 'Setting with this key already exists';
                }
            }

            $setting->update($data);
            return $setting->fresh();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Delete setting by ID
     */
    public static function deleteSettingById($id)
    {
        try {
            $setting = self::$model::find($id);

            if (!$setting) {
                return 'Setting not found';
            }

            $setting->delete();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update or create setting by key
     */
    public static function updateOrCreateSetting($key, $value)
    {
        try {
            return self::$model::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
