<?php

namespace irrigation;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Measured extends Model
{
    protected $table = 'measureds';

    public function scopeLastDay($query)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDay(3));
    }
}

