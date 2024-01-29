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


    public function organisation() // The RDC managing this concession
    {
        return $this->belongsTo(Organisation::class);
    }

    public function wards() // Wards covered by the concession
    {
        return $this->belongsToMany(Organisation::class, 'hunting_concession_ward', 'hunting_concession_id', 'ward_id');
    }

    public function quotaRequests() // Quota requests initiated by this concession
    {
        return $this->hasMany(QuotaRequest::class);
    }

    public function huntingActivities() // Activities taking place in this concession
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
