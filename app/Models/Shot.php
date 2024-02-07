<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Shot extends Model
{
    use HasFactory,HasSlug;

    protected $guarded = [];

    //has many relationship with hunting detail out come
    public function huntingDetailOutCome()
    {
        return $this->hasMany(HuntingDetailOutCome::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name'])
            ->saveSlugsTo('slug');
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }
}
