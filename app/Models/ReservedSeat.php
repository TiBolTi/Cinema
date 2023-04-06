<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedSeat extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function movieSeance()
    {
        return $this->belongsTo(MovieSeance::class);
    }
}
