<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CinemaHall extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function reservedSeat()
    {
        return $this->hasMany(ReservedSeat::class);
    }
}
