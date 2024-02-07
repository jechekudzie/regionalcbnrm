<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Hunter extends Model
{
    use HasFactory,HasSlug;

    protected $guarded = [];

    //belong to a country
    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function organisations()
    {
        return $this->belongsToMany(Organisation::class, 'organisation_hunter');
    }

    public function huntingActivities()
    {
        return $this->belongsToMany(HuntingActivity::class, 'hunting_activity_hunter');
    }


    //has many hunting detail out comes
    public function huntingDetailOutComes()
    {
        return $this->hasMany(HuntingDetailOutCome::class);
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
