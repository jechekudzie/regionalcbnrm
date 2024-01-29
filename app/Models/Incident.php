<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Incident extends Model
{
    use HasFactory,HasSlug;

    //guarded
    protected $guarded = [];

    public function conflictTypes()
    {
        // Custom pivot table and column names
        return $this->belongsToMany(ConflictType::class, 'incident_conflict_type', 'incident_id', 'conflict_type_id');
    }

    public function conflictOutcomes()
    {
        // Custom pivot table and column names
        return $this->belongsToMany(ConflictOutcome::class, 'incident_conflict_outcome', 'incident_id', 'conflict_outcome_id');
    }

    public function species()
    {
        return $this->belongsToMany(Species::class, 'incident_species', 'incident_id', 'species_id');
    }


    public function controlMeasures()
    {
        return $this->belongsToMany(ControlMeasure::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['title','organisation_id'])
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
