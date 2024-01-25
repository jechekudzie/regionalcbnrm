<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class HuntingConcession extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = [];


    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function huntingActivities()
    {
        return $this->hasMany(HuntingActivity::class);
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
