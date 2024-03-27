<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueSharing extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function payableItem()
    {
        return $this->belongsTo(PayableItem::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

}
