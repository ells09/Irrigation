<?php

// app/Models/Measured.php

namespace App\Models;

/**
 * Created by PhpStorm.
 * User: inkre1
 * Date: 15-04-30
 * Time: 15:57
 */

use Illuminate\Database\Eloquent\Model;

class Measured extends Model{

  protected $fillable = array('humidity', 'temperature', 'temperature2', 'hygrometer' );

  public function scopeGetMin($query, $column) {
      return $query->selectRaw("min($column) as minValue");
  }

  public function scopeGetMax($query, $column) {
      return $query->selectRaw("max($column) as maxValue");
  }

  public function scopeGetMinMax($query, $column) {
      return $query->selectRaw("min($column) as minVal, max($column) as maxVal, created_at");
  }


}