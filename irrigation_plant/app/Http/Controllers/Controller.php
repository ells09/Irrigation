<?php

namespace irrigation\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use irrigation\Measured;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function update(Measured $measured)
    {
        setlocale(LC_ALL, "sv_SE.UTF-8");
        $dateLow = Carbon::now()->subHour();
        $data = $measured->orderBy('created_at', 'desc')->take(60)->get();
        //$data = $measured->where('created_at', '>',$dateLow)->get();
        foreach ($data as $item) {
            $return['temp1'][] = $item->temperature_1;
            $return['temp2'][] = $item->temperature_2;
            $return['humidity'][] = $item->humidity;
            $return['hygrometer'][] = $item->hygrometer;
            $return['labels'][] = $item->created_at->format('H:i');
        }
        $time = strftime("%H:%M", time());
        return $return;
    }
}
