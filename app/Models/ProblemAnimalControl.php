<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProblemAnimalControl extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class); // Assuming you have an Organization model
    }

    public function incident()
    {
        return $this->belongsTo(Incident::class); // Assuming you have an Incident model
    }

    public function pacDetails()
    {
        return $this->hasMany(PACDetail::class);
    }
}
