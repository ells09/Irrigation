<?php
/**
 * Created by PhpStorm.
 * User: inkre1
 * Date: 15-06-09
 * Time: 09:13
 */

namespace App\Commands;

use App\reports;

trait ChartTrait {

    private $time;
    private $minMaxValues;
    private $presentationFormat;

    public function maxVal()
    {
        return $this->minMaxValues[0]['maxVal'];
    }

    public function minVal()
    {
        return $this->minMaxValues[0]['minVal'];
    }

    private function readLatestValue($column)
    {
        $latest = reports::latest()->take(1)->get([$column, 'created_at']);
        $time = $latest[0]['created_at'];
        $this->readMinMaxValues($column, $time);

        return $latest;

    }

    private function readMinMaxValues($column, $time)
    {

        $this->minMaxValues = reports::getInterval($time->subHour())->getMinMax($column)->get();
    }

    private function setPresentationFormat($format = 'hour')
    {
        $this->presentationFormat = $format;
    }
}