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

    public function index(Measured $measured)
    {
        $rows = $measured->orderBy('created_at', 'desc')->take(60)->get();

        foreach ($rows as $row) {
            $dataSet_1[] = $row->temperature_1;
            $dataSet_2[] = $row->temperature_2;
            $dataSet_3[] = $row->humidity;
            $dataSet_4[] = $row->hygrometer;
            $labels[] = $row->created_at->format('H:i');
        }
        $values = collect([
            array_reverse($dataSet_1),
            array_reverse($dataSet_2),
            array_reverse($dataSet_3),
            array_reverse($dataSet_4),
        ]);
        $labels = collect(array_reverse($labels));
        return view('welcome', compact('values', 'labels'));
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
        //$data = $measured->orderBy('created_at', 'desc')->take(1)->get();
        $data = $measured->latest()->first();

        $return['data'][] = [
            [
                $data->temperature_1,
                $data->temperature_2,
                $data->humidity,
                $data->hygrometer,
            ],
            $data->created_at->format('H:i')
        ];
        $id = $data->id - 60;

        $return['minTemp1'] = $measured->where('id', '>', $id)->min('temperature_1');
        $return['maxTemp1'] = $measured->where('id', '>', $id)->max('temperature_1');
        $return['minTemp2'] = $measured->where('id', '>', $id)->min('temperature_2');
        $return['maxTemp2'] = $measured->where('id', '>', $id)->max('temperature_2');
        $return['minHumidity'] = $measured->where('id', '>', $id)->min('humidity');
        $return['maxHumidity'] = $measured->where('id', '>', $id)->max('humidity');
        $return['minHygrometer'] = $measured->where('id', '>', $id)->min('hygrometer');
        $return['maxHygrometer'] = $measured->where('id', '>', $id)->max('hygrometer');

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
