<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poacher extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function poachingIncidents()
    {
        return $this->belongsToMany(PoachingIncident::class, 'incident_poachers');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function identificationType()
    {
        return $this->belongsTo(IdentificationType::class);
    }

    public function offenceType()
    {
        return $this->belongsTo(OffenceType::class);
    }

    public function poacherType()
    {
        return $this->belongsTo(PoacherType::class);
    }

    public function poachingReason()
    {
        return $this->belongsTo(PoachingReason::class);
    }

}
