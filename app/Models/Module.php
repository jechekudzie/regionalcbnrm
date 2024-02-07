<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Module extends Model
{
    use HasFactory,HasSlug;


    protected $guarded = [];
    protected static function booted()
    {
        static::created(function ($module) {
            // Define the actions for which permissions will be created
            $actions = ['view', 'create', 'read', 'update', 'delete'];

            foreach ($actions as $action) {
                // Format the permission name: e.g., 'create-user-management'
                $permissionName = strtolower($action . '-' . str_replace(' ', '-', $module->name));

                // Create the permission
                Permission::create(['name' => $permissionName]);
            }
        });
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }
}
