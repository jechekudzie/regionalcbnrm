<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PACDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function problemAnimalControl()
    {
        return $this->belongsTo(ProblemAnimalControl::class);
    }

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function controlMeasures()
    {
        return $this->belongsToMany(ControlMeasure::class, 'pac_detail_control_measure', 'pac_detail_id', 'control_measure_id')
            ->withPivot(['male_count', 'female_count', 'location', 'latitude', 'longitude', 'remarks']);
    }
}
