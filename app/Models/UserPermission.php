<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = ['role', 'route_name'];

    public static function routeNameList()
    {
        return [
            'pages',
            'navigation-menus',
            'dashboard',
            'users',
            'events',
            'user-permissions'
        ];
    }

    /**
     * Check if $role has access to $route
     *
     * @param  mixed $role
     * @param  mixed $route
     * @return void
     */
    public static function roleHasAccessTo($role, $route)
    {
        try {
            $model = static::where('role', $role)
                ->where('route_name', $route)
                ->first();
            return $model ? true : false;
        } catch (\Throwable $th) {
            return false;
        }
    }
}