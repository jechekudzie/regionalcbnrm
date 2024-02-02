<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class QuotaRequest extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = [];


    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function wardQuotaDistributions()
    {
        return $this->hasMany(WardQuotaDistribution::class);
    }

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['hunting_concession_id', 'year','species_id']) // Fields as an array
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


}
