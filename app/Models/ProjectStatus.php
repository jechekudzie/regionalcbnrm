<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ProjectStatus extends Model
{
    use HasFactory,HasSlug;

    protected $guarded = [];


    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    //project timeline
    public function timelines()
    {
        return $this->hasMany(ProjectTimeline::class);
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
