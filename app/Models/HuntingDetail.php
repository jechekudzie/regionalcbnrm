<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class HuntingDetail extends Model
{
    use HasFactory,HasSlug;

    protected $guarded = [];

    public function huntingActivity()
    {
        return $this->belongsTo(HuntingActivity::class);
    }

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    //hunting concession
    public function huntingConcession()
    {
        return $this->belongsTo(HuntingConcession::class);
    }

    //has many hunting detail out comes
    public function huntingDetailOutComes()
    {
        return $this->hasMany(HuntingDetailOutCome::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['hunting_activity_id','species_id','hunting_concession_id','quota_request_id'])
            ->saveSlugsTo('slug');
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }
}

