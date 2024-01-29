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
    use HasFactory, HasSlug;

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


    //hunting clients
    public function hunters()
    {
        return $this->belongsToMany(Hunter::class, 'organisation_hunter');//safari hunters
    }

    public function huntingActivitiesAsSafariOperator() // When the organisation is a Safari Operator
    {
        return $this->hasMany(HuntingActivity::class);
    }

    public function huntingConcessions() // When the organisation is an RDC
    {
        return $this->hasMany(HuntingConcession::class);
    }

    public function huntingLicenses() // Licenses held or issued by the organisation
    {
        return $this->hasMany(HuntingLicense::class);
    }

    //wards coveredWards by the hunting concession
    public function coveredWards()
    {
        return $this->belongsToMany(Organisation::class, 'hunting_concession_ward', 'hunting_concession_id', 'ward_id');
    }

    //has many incidents
    public function incidents()
    {
        return $this->hasMany(Incident::class);
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
