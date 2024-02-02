<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class WardQuotaDistribution extends Model
{
    use HasFactory,HasSlug;

    protected $guarded = [];

    public function quotaRequest()
    {
        return $this->belongsTo(QuotaRequest::class);
    }

    public function ward()
    {
        return $this->belongsTo(Organisation::class, 'ward_id');
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['id','quota_request_id']) // Fields as an array
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
