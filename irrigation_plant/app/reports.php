<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class reports extends Model {

    protected $table = 'measureds';

    public function scopeGetMinMax($query, $column) {
        return $query->selectRaw("min($column) as minVal, max($column) as maxVal, created_at");
    }

    public function scopeGetMinMaxH($query, $column) {
        return $query->selectRaw("min($column) DIV 2 as minVal, max($column) DIV 2 as maxVal, created_at");
    }

    public function scopeGetInterval($query, $interval) {
        return $query->where('created_at', '>', $interval);
    }
}
