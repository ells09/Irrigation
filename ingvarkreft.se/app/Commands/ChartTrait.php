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

    public function maxVal($key)
    {
        return $this->minMaxValues->max($key);
    }

    public function minVal($key)
    {
        return $this->minMaxValues->min($key);
    }

    private function readLatestValue($column)
    {
        $latest = reports::latest()->take(1)->get([$column, 'created_at']);
        $time = $latest[0]['created_at'];
        $this->readMinMaxValues($time->subHour());

        return $latest;

    }

    private function readMinMaxValues($time)
    {

        $this->minMaxValues = reports::latest()
            ->getInterval($time)
            ->get([
                'temperature_1',
                'temperature_2',
                'humidity',
                'hygrometer',
                'hygro_raw',
                'created_at'])
            ->reverse();
    }

    private function setPresentationFormat($format = 'hour')
    {
        $this->presentationFormat = $format;
    }
}
