<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class HuntingActivity extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = [];

    public function organisation() // The Safari Operator organizing this activity
    {
        return $this->belongsTo(Organisation::class);
    }

    public function huntingConcession()
    {
        return $this->belongsTo(HuntingConcession::class);
    }

    public function hunters()
    {
        return $this->belongsToMany(Hunter::class, 'hunting_activity_hunter');
    }


    public function huntingDetails()
    {
        return $this->hasMany(HuntingDetail::class);
    }

    public function huntingVehicles()
    {
        return $this->hasMany(HuntingActivityVehicle::class);
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
