<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PopulationEstimate extends Model
{
    use HasFactory,HasSlug;

    protected $guarded = [];

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'conducted_by');
    }

    public function countingMethod()
    {
        return $this->belongsTo(CountingMethod::class);
    }

    public function maturity()
    {
        return $this->belongsTo(Maturity::class);
    }

    public function speciesGender()
    {
        return $this->belongsTo(SpeciesGender::class);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['organisation_id', 'year']) // Fields as an array
            ->saveSlugsTo('slug');

    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
