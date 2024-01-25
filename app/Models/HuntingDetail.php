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

