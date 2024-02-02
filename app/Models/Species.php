<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Species extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = [];

    public function populationEstimates()
    {
        return $this->hasMany(PopulationEstimate::class);
    }

    public function incidents()
    {
        return $this->belongsToMany(Incident::class, 'incident_species', 'species_id', 'incident_id');
    }


    public function getEstimateCount($maturityId, $genderId, $year)
    {
        return $this->populationEstimates()
            ->where('maturity_id', $maturityId)
            ->where('species_gender_id', $genderId)
            ->where('year', $year)
            ->sum('estimate');
    }


    public function quotaRequests()
    {
        return $this->hasMany(QuotaRequest::class);
    }

    public function huntingDetails()
    {
        return $this->hasMany(HuntingDetail::class);
    }


    public function poachingIncidents()
    {
        return $this->belongsToMany(PoachingIncident::class, 'poaching_incident_species');
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
