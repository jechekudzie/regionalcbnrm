<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Project extends Model
{
    use HasFactory,HasSlug;

    protected $guarded = [];

    //belongs to organisation
    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }
    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    public function budgets()
    {
        return $this->hasMany(ProjectBudget::class);
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    public function photos()
    {
        return $this->hasMany(ProjectPhoto::class);
    }

    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function stakeholders()
    {
        return $this->hasMany(Stakeholder::class);
    }

    public function testimonials()
    {
        return $this->hasMany(ProjectTestimonial::class);
    }

    public function timelines()
    {
        return $this->hasMany(ProjectTimeline::class);
    }

    public function resources()
    {
        return $this->hasMany(ProjectResource::class);
    }

    public function evaluations()
    {
        return $this->hasMany(ProjectEvaluation::class);
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
