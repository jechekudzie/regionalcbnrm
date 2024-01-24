<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Organisation extends Model
{
    use HasFactory,HasSlug;

    protected $guarded = [];

    //belongs to many users
    public function users()
    {
        return $this->belongsToMany(User::class, 'organisation_users')
            ->withPivot('role_id');
    }

    //has many roles
    public function organisationRoles()
    {
        return $this->hasMany(Role::class, 'organisation_id');
    }

    public function availablePermissions()
    {
        return $this->belongsToMany(Permission::class, 'organisation_permissions');
    }


    public function parentOrganisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }
    public function childOrganisations()
    {
        return $this->hasMany(Organisation::class, 'organisation_id');
    }

    public function getAllChildren()
    {
        $children = [];

        foreach ($this->childOrganisations as $child) {
            $children[] = $child;
            $children = array_merge($children, $child->getAllChildren());
        }

        return $children;
    }

    //has many organisations
    public function organisations()
    {
        return $this->hasMany(Organisation::class);
    }
    public function organisationType()
    {
        return $this->belongsTo(OrganisationType::class);
    }

    //has many population estimates
    public function populationEstimates()
    {
        return $this->hasMany(PopulationEstimate::class);
    }


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
