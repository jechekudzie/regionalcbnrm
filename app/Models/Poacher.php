<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Poacher extends Model
{
    use HasFactory,HasSlug;

    protected $guarded = [];

    public function poachingIncidents()
    {
        return $this->belongsTo(PoachingIncident::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function identificationType()
    {
        return $this->belongsTo(IdentificationType::class);
    }

    public function offenceType()
    {
        return $this->belongsTo(OffenceType::class);
    }

    public function poacherType()
    {
        return $this->belongsTo(PoacherType::class);
    }

    public function poachingReason()
    {
        return $this->belongsTo(PoachingReason::class);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('full_name')
            ->saveSlugsTo('slug');
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }

}
