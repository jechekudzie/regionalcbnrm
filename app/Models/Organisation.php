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
        return $this->hasMany(PopulationEstimate::class, 'conducted_by');
    }

    public function quotaRequests()
    {
        return $this->hasMany(QuotaRequest::class, 'organisation_id');
    }



    //hunting stuff
    public function hunters()
    {
        return $this->belongsToMany(Hunter::class, 'organisation_hunter');
    }

    public function huntingActivities()
    {
        return $this->hasMany(HuntingActivity::class);
    }

    public function huntingLicenses()
    {
        return $this->hasMany(HuntingLicense::class);
    }

    public function huntingConcessions()
    {
        return $this->hasMany(HuntingConcession::class);
    }

    public function getSlugOptions() : SlugOptions
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
