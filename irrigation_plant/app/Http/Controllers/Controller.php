<?php

namespace irrigation\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use irrigation\Measured;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        setlocale(LC_ALL, "sv_SE.UTF-8");
        Carbon::setLocale('sv');
    }

    public function getHour(Measured $measured)
    {
        $data = $measured->orderBy('created_at', 'desc')->take(60)->get();

        foreach ($data as $item) {
            $return['data'][] = [
                [
                    $item->temperature_1,
                    $item->temperature_2,
                    $item->humidity,
                    $item->hygrometer,
                ],
                $item->created_at->format('H:i')
            ];
        }

        return $return;
    }

    public function getLastMinute (Measured $measured)
    {
        $data = $measured->orderBy('created_at', 'desc')->take(1)->get();

        foreach ($data as $item) {
            $return['data'][] = [
                [
                    $item->temperature_1,
                    $item->temperature_2,
                    $item->humidity,
                    $item->hygrometer,
                ],
                $item->created_at->format('H:i')
            ];
        }

        return $return;

    }

    public function getLastHour(Measured $measured)
    {

    }

    public function getDay()
    {
        $return = [];
        $sql = "SELECT
                  AVG(temperature_1) as temperature_1,
                  MIN(temperature_1) as min_temperature_1,
                  MAX(temperature_1) as max_temperature_1,
                  AVG(temperature_2) as temperature_2,
                  MIN(temperature_2) as min_temperature_2,
                  MAX(temperature_2) as max_temperature_2,
                  AVG(humidity) as humidity,
                  MIN(humidity) as min_humidity,
                  MAX(humidity) as max_humidity,
                  AVG(hygrometer) as hygrometer,
                  MIN(hygrometer) as min_hygrometer,
                  MAX(hygrometer) as max_hygrometer,
                  HOUR(created_at) as hour FROM measureds
                WHERE DATE_SUB(created_at,INTERVAL 1 HOUR) And
                  created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)
                GROUP BY HOUR(created_at)
                ORDER BY id ASC";

        $data = DB::select($sql);

        foreach ($data as $item) {
            $return['data'][] = [
                [
                    $item->temperature_1,
                    $item->temperature_2,
                    $item->humidity,
                    $item->hygrometer,
                ],
                $item->hour . ':00'
            ];
        }
        return $return;

        /*
                SELECT AVG(temperature_1) as temperature_1, AVG(temperature_2) as temperature_2,
                HOUR(`created_at`) FROM measureds
                WHERE DATE_SUB(`created_at`,INTERVAL 1 HOUR) And
                created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)
                GROUP BY HOUR(created_at)
                ORDER BY id ASC
                */
    }
}
