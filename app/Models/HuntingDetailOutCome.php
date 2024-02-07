<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class HuntingDetailOutCome extends Model
{
    use HasFactory,HasSlug;


    protected $guarded = [];

   /* protected $casts = [
        'pictures' => 'array',
    ];*/


    //belongs to relationship with hunting detail
    public function huntingDetail()
    {
        return $this->belongsTo(HuntingDetail::class);
    }

    public function huntingOutCome()
    {
        return $this->belongsTo(HuntingOutCome::class);
    }

    //belong to shot
    public function shot()
    {
        return $this->belongsTo(Shot::class);
    }

    //belongs to hunter
    public function hunter()
    {
        return $this->belongsTo(Hunter::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['hunter_id','hunting_detail_id'])
            ->saveSlugsTo('slug');
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }


}
