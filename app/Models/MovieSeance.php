<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieSeance extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function reservedSeat()
    {
        return $this->hasMany(Ticket::class);
    }
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    public function cinemaHall()
    {
        return $this->belongsTo(CinemaHall::class);
    }
    public function time()
    {
        return $this->belongsTo(Time::class);
    }
}
