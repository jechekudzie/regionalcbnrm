<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

    public function ConflictOutComes()
    {
        // Custom pivot table and column names
        return $this->belongsToMany(ConflictOutCome::class, 'incident_conflict_outcome', 'incident_id', 'conflict_outcome_id');
    }

    public function species()
    {
        return $this->belongsToMany(Species::class, 'incident_species', 'incident_id', 'species_id')
            ->withPivot('male_count', 'female_count');
    }

    public function problemAnimalControls()
    {
        return $this->hasMany(ProblemAnimalControl::class);
    }


    public function controlMeasures()
    {
        return $this->belongsToMany(ControlMeasure::class);
    }


    public function getDynamicFieldValuesAttribute()
    {
        return DB::table('conflict_outcome_dynamic_field_values as pivot')
            ->join('dynamic_fields as fields', 'pivot.dynamic_field_id', '=', 'fields.id')
            ->where('pivot.incident_id', $this->id)
            ->select('fields.*', 'pivot.value as fieldValue')
            ->get();
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
