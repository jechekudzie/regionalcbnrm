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


    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function huntingConcession() // The concession requesting the quota
    {
        return $this->belongsTo(HuntingConcession::class);
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
