<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopulationEstimate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function speciesGender()
    {
        return $this->belongsTo(SpeciesGender::class);
    }

    public function countingMethod()
    {
        return $this->belongsTo(CountingMethod::class);
    }

    public function conductedBy()
    {
        return $this->belongsTo(Organisation::class, 'conducted_by');
    }


}
